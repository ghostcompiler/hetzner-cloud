#!/usr/bin/env python3
"""Build demo/includes/method_summaries.json and docs/METHOD_REFERENCE.md from cloud.spec.json."""

from __future__ import annotations

import json
import re
import urllib.request
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SPEC = ROOT / "demo" / "includes" / "cloud.spec.cache.json"
SPEC_URL = "https://docs.hetzner.cloud/cloud.spec.json"
OUT_JSON = ROOT / "demo" / "includes" / "method_summaries.json"
OUT_MD = ROOT / "docs" / "METHOD_REFERENCE.md"

# Must match Ghostcompiler\Hetzner\HetznerClient property names
EXPECTED = [
    "actions",
    "certificates",
    "datacenters",
    "firewalls",
    "floatingIps",
    "images",
    "isos",
    "loadBalancers",
    "loadBalancerTypes",
    "locations",
    "networks",
    "placementGroups",
    "pricing",
    "primaryIps",
    "servers",
    "serverTypes",
    "sshKeys",
    "volumes",
    "zones",
]


def segment_to_resource(seg: str) -> str:
    parts = seg.split("_")
    return parts[0] + "".join(p.title() for p in parts[1:])


def operation_id_to_method(oid: str) -> str:
    parts = oid.split("_")
    return parts[0] + "".join(p.title() for p in parts[1:])


def first_path_segment(path: str) -> str | None:
    segs = [s for s in path.strip("/").split("/") if s and not s.startswith("{")]
    return segs[0] if segs else None


def clean_desc(text: str, max_len: int = 400) -> str:
    if not text:
        return ""
    t = text.strip()
    t = re.sub(r"\[([^\]]+)\]\([^)]+\)", r"\1", t)  # [text](url) -> text
    t = re.sub(r"<[^>]+>", " ", t)
    t = re.sub(r"\s+", " ", t).strip()
    para = t.split("\n\n")[0] if "\n\n" in t else t.split("\n")[0]
    if len(para) > max_len:
        para = para[: max_len - 1].rsplit(" ", 1)[0] + "…"
    return para


def main() -> None:
    if not SPEC.is_file():
        SPEC.parent.mkdir(parents=True, exist_ok=True)
        print("Downloading", SPEC_URL, "->", SPEC)
        urllib.request.urlretrieve(SPEC_URL, SPEC)

    data = json.loads(SPEC.read_text(encoding="utf-8"))
    by_res: dict[str, dict[str, dict]] = {}

    for path, ops in data.get("paths", {}).items():
        seg = first_path_segment(path)
        if not seg:
            continue
        res = segment_to_resource(seg)
        res = res[0].lower() + res[1:] if res else res

        for http_m, spec in ops.items():
            if http_m not in ("get", "post", "put", "delete", "patch"):
                continue
            oid = (spec.get("operationId") or "").strip()
            if not oid:
                continue
            meth = operation_id_to_method(oid)
            summ = (spec.get("summary") or "").strip()
            desc = clean_desc(spec.get("description") or "")
            by_res.setdefault(res, {})[meth] = {
                "summary": summ,
                "detail": desc,
                "http": http_m.upper(),
                "path": path,
            }

    OUT_JSON.parent.mkdir(parents=True, exist_ok=True)
    OUT_JSON.write_text(json.dumps(by_res, indent=2), encoding="utf-8")

    lines = [
        "# Hetzner Cloud API — method reference",
        "",
        "Summaries and short descriptions are taken from the official "
        "[Hetzner Cloud OpenAPI spec](https://docs.hetzner.cloud/cloud.spec.json). "
        "Use this alongside the [interactive demo](../demo/) and "
        "[API docs](https://docs.hetzner.cloud/reference/cloud).",
        "",
    ]

    for res in sorted(by_res.keys()):
        methods = by_res[res]
        title = res[0].upper() + res[1:] if res else res
        lines.append(f"## `{res}` ({title}Client)")
        lines.append("")
        lines.append("| Method | HTTP | Path | Summary |")
        lines.append("| --- | --- | --- | --- |")
        for mname in sorted(methods.keys()):
            info = methods[mname]
            summ = info["summary"].replace("|", "\\|")
            path = info["path"].replace("|", "\\|")
            lines.append(
                f"| `{mname}()` | {info['http']} | `{path}` | {summ} |"
            )
        lines.append("")
        lines.append("### Details")
        lines.append("")
        for mname in sorted(methods.keys()):
            info = methods[mname]
            detail = info["detail"].replace("|", "\\|") if info["detail"] else "_No extra description in spec._"
            lines.append(f"- **`{mname}()`** — {info['summary']}")
            lines.append(f"  - {detail}")
            lines.append("")

    OUT_MD.parent.mkdir(parents=True, exist_ok=True)
    OUT_MD.write_text("\n".join(lines), encoding="utf-8")

    for r in EXPECTED:
        if r not in by_res:
            print("WARN: missing resource", r)
    for k in sorted(by_res.keys()):
        if k not in EXPECTED:
            print("WARN: extra resource", k)

    n = sum(len(v) for v in by_res.values())
    print(f"Wrote {OUT_JSON} and {OUT_MD} ({len(by_res)} resources, {n} methods)")


if __name__ == "__main__":
    main()

<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/explorer.php';

$autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (! is_readable($autoload)) {
    http_response_code(500);
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Demo</title></head><body>';
    echo '<p>Run <code>composer install</code> in the project root, then reload.</p></body></html>';
    exit;
}

require_once $autoload;

$manifest = hetzner_demo_manifest();
$manifestJson = json_encode($manifest, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hetzner Cloud SDK — API explorer (all methods)</title>
    <style>
        :root {
            --bg: #eef2ff;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --accent: #4f46e5;
            --accent-hover: #4338ca;
            --border: #c7d2fe;
            --card-shadow: 0 4px 14px rgba(79, 70, 229, 0.08);
            font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
            line-height: 1.45;
            color: var(--text);
            background: var(--bg);
        }
        body { margin: 0; padding: 0 0 2.5rem; }
        .top {
            position: sticky; top: 0; z-index: 20;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 45%, #4338ca 100%);
            color: #e0e7ff;
            padding: 1rem 1.25rem;
            box-shadow: 0 8px 32px rgba(30, 27, 75, 0.35);
        }
        .top-inner { max-width: 1100px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; }
        .brand { flex: 1 1 200px; }
        .brand h2 { margin: 0 0 0.25rem; font-size: 1.05rem; font-weight: 700; letter-spacing: -0.02em; }
        .brand p { margin: 0; font-size: 0.78rem; opacity: 0.85; }
        .top label { font-size: 0.75rem; font-weight: 600; display: block; margin-bottom: 0.35rem; color: #a5b4fc; text-transform: uppercase; letter-spacing: 0.04em; }
        .top input[type=password], .top input[type=text] {
            min-width: 240px; padding: 0.55rem 0.75rem; border-radius: 8px;
            border: 1px solid rgba(165, 180, 252, 0.35); background: rgba(15, 23, 42, 0.45);
            color: #f8fafc; font: inherit;
        }
        .top input::placeholder { color: #818cf8; opacity: 0.7; }
        .top button {
            padding: 0.5rem 1rem; border-radius: 8px; border: none; font-weight: 600; cursor: pointer;
            background: #fbbf24; color: #1e1b4b; transition: transform 0.12s, filter 0.12s;
        }
        .top button:hover { filter: brightness(1.05); transform: translateY(-1px); }
        .top button.secondary { background: rgba(255,255,255,0.15); color: #e0e7ff; }
        .top button.secondary:hover { background: rgba(255,255,255,0.22); }
        .hint-top { font-size: 0.78rem; color: var(--muted); max-width: 1100px; margin: 0.65rem auto 0; padding: 0 1.25rem; }
        .wrap { max-width: 1100px; margin: 1.25rem auto; padding: 0 1.25rem; }
        .filter {
            width: 100%; max-width: 420px; padding: 0.6rem 0.85rem; border-radius: 10px;
            border: 1px solid var(--border); font: inherit; margin-bottom: 1rem;
            background: var(--surface); box-shadow: var(--card-shadow);
        }
        details.client {
            background: var(--surface); border: 1px solid var(--border); border-radius: 12px;
            margin-bottom: 0.75rem; overflow: hidden; box-shadow: var(--card-shadow);
        }
        details.client > summary {
            padding: 0.85rem 1.1rem; cursor: pointer; font-weight: 700; font-size: 0.95rem;
            background: linear-gradient(90deg, #f5f3ff 0%, #eef2ff 100%);
            list-style: none; display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid transparent;
        }
        details.client[open] > summary { border-bottom-color: var(--border); }
        details.client > summary::-webkit-details-marker { display: none; }
        details.client > summary::after { content: "▸"; color: var(--accent); font-size: 0.9rem; }
        details.client[open] > summary::after { content: "▾"; }
        .method {
            border-top: 1px solid #e2e8f0; padding: 1rem 1.1rem 1.1rem; font-size: 0.9rem;
            background: linear-gradient(180deg, #fafaff 0%, #fff 40%);
        }
        .method:first-of-type { border-top: none; }
        .method-head { display: flex; flex-wrap: wrap; gap: 0.65rem; align-items: flex-start; margin-bottom: 0.5rem; }
        .method-name { font-family: ui-monospace, "Cascadia Code", monospace; font-weight: 700; color: var(--accent); font-size: 0.92rem; }
        .method-meta { flex: 1 1 180px; font-size: 0.72rem; color: var(--muted); }
        .method-meta code { background: #e0e7ff; color: #3730a3; padding: 0.1em 0.35em; border-radius: 4px; font-size: 0.85em; }
        .method-desc { font-size: 0.82rem; color: #334155; margin: 0 0 0.65rem; line-height: 1.5; }
        .method-desc strong { color: #1e293b; }
        .method-detail { font-size: 0.78rem; color: var(--muted); margin: 0 0 0.75rem; padding: 0.5rem 0.65rem; background: #f1f5f9; border-radius: 8px; border-left: 3px solid var(--accent); }
        .method-run {
            padding: 0.4rem 0.9rem; border-radius: 8px; border: none; background: var(--accent); color: #fff;
            font-weight: 600; cursor: pointer; font-size: 0.82rem; align-self: flex-start;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.35);
        }
        .method-run:hover { background: var(--accent-hover); }
        .method-run:disabled { opacity: 0.55; cursor: not-allowed; transform: none; box-shadow: none; }
        .method-run.busy { background: #64748b; }
        .param-row { margin: 0.4rem 0 0; display: grid; grid-template-columns: 110px 1fr; gap: 0.35rem 0.75rem; align-items: start; font-size: 0.82rem; }
        .param-row label { font-weight: 600; color: #475569; }
        .param-row input, .param-row textarea {
            width: 100%; box-sizing: border-box; padding: 0.4rem 0.5rem;
            border: 1px solid #cbd5e1; border-radius: 8px; font: inherit; background: #fff;
        }
        .param-row textarea { min-height: 3.4rem; font-family: ui-monospace, monospace; font-size: 0.78rem; }
        .out { margin-top: 0.65rem; display: none; }
        .out.visible { display: block; }
        .out pre { margin: 0; padding: 0.75rem; border-radius: 10px; font-size: 0.74rem; overflow: auto; max-height: 340px; white-space: pre-wrap; word-break: break-word; }
        .out.ok pre { background: #0f172a; color: #e2e8f0; }
        .out.err pre { background: #450a0a; color: #fecaca; }
        .copy-btn { margin-top: 0.4rem; padding: 0.3rem 0.65rem; font-size: 0.74rem; border-radius: 6px; border: 1px solid #94a3b8; background: #fff; cursor: pointer; }
        .copy-btn:hover { background: #f8fafc; }
        .warn {
            background: linear-gradient(90deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #f59e0b; padding: 0.85rem 1rem; border-radius: 12px; margin-bottom: 1rem;
            font-size: 0.88rem; box-shadow: var(--card-shadow);
        }
        .count { font-size: 0.82rem; color: var(--muted); margin-bottom: 0.5rem; }
        .footer-hint { font-size: 0.82rem; color: var(--muted); margin-top: 2rem; }
    </style>
</head>
<body>
    <div class="top">
        <div class="top-inner">
            <div class="brand">
                <h2>Hetzner Cloud SDK explorer</h2>
                <p>Live calls · official API descriptions · copy JSON responses</p>
            </div>
            <div>
                <label for="apiToken">API token (enter once)</label>
                <input type="password" id="apiToken" placeholder="Paste project token" autocomplete="off">
            </div>
            <div style="display:flex;gap:0.5rem;flex-wrap:wrap;padding-bottom:2px;">
                <button type="button" id="btnSave">Save in browser</button>
                <button type="button" class="secondary" id="btnClear">Clear token</button>
            </div>
        </div>
    </div>
    <p class="hint-top">Local use only. “Save in browser” stores the token in <code>localStorage</code>. Do not expose this demo on a public server.</p>

    <div class="wrap">
        <div class="warn"><strong>How it works:</strong> expand a client → each method shows an official <strong>summary</strong>, <strong>HTTP + path</strong>, and a <strong>description</strong> (from Hetzner’s OpenAPI spec). Fill <strong>required</strong> fields; JSON parameters must be valid (<code>[]</code>, <code>{}</code>, etc.). Leave optional fields empty to use SDK defaults → <strong>Run</strong>. The API response appears below; <strong>Copy response</strong> copies the full JSON envelope (<code>ok</code> / <code>result</code> or error fields).</div>
        <input type="search" class="filter" id="filter" placeholder="Search client or method name…" autocomplete="off">
        <p class="count" id="countLine"></p>
        <div id="root"></div>
    </div>

    <textarea id="hetzner-manifest" hidden readonly><?= htmlspecialchars($manifestJson, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea>
    <script>
(function () {
    const manifest = JSON.parse(document.getElementById('hetzner-manifest').value);
    const TOKEN_KEY = 'hetzner_demo_token_v1';
    const tokenEl = document.getElementById('apiToken');
    const root = document.getElementById('root');
    const filterEl = document.getElementById('filter');
    const countLine = document.getElementById('countLine');

    try {
        tokenEl.value = localStorage.getItem(TOKEN_KEY) || '';
    } catch (e) {}

    document.getElementById('btnSave').onclick = function () {
        try {
            localStorage.setItem(TOKEN_KEY, tokenEl.value.trim());
            alert('Token saved in this browser.');
        } catch (e) {
            alert('Could not save: ' + e);
        }
    };
    document.getElementById('btnClear').onclick = function () {
        tokenEl.value = '';
        try { localStorage.removeItem(TOKEN_KEY); } catch (e) {}
    };

    function defaultJsonForParam(p) {
        if (p.array) {
            if (p.name === 'query' || p.name === 'extra') return '[]';
            if (p.name === 'body') return '{}';
            if (p.name === 'ids') return '[1]';
            return '[]';
        }
        if (p.optional && p.default !== undefined && p.default !== null) {
            return String(p.default);
        }
        return '';
    }

    function collectParams(card, methodMeta) {
        const params = {};
        for (const p of methodMeta.params) {
            const inp = card.querySelector('[data-p="' + p.name + '"]');
            if (!inp) continue;
            const raw = inp.value.trim();
            if (raw === '') {
                if (p.optional) continue;
                throw new Error('Fill parameter: ' + p.name);
            }
            if (p.array) {
                let v;
                try {
                    v = JSON.parse(raw);
                } catch (e) {
                    throw new Error(p.name + ': invalid JSON');
                }
                if (typeof v !== 'object' || v === null) {
                    throw new Error(p.name + ': must be JSON array or object');
                }
                params[p.name] = v;
            } else {
                params[p.name] = raw;
            }
        }
        return params;
    }

    async function runMethod(resource, methodMeta, card) {
        const token = tokenEl.value.trim();
        if (!token) {
            alert('Enter your API token above (optional: Save in browser).');
            tokenEl.focus();
            return;
        }
        let params;
        try {
            params = collectParams(card, methodMeta);
        } catch (e) {
            alert(e.message);
            return;
        }
        const btn = card.querySelector('.method-run');
        const out = card.querySelector('.out');
        const pre = out.querySelector('pre');
        btn.disabled = true;
        btn.classList.add('busy');
        btn.textContent = '…';
        out.classList.remove('visible', 'ok', 'err');
        try {
            const res = await fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ token, resource, method: methodMeta.name, params })
            });
            const text = await res.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                pre.textContent = text || '(empty)';
                out.classList.add('visible', 'err');
                return;
            }
            const pretty = JSON.stringify(data, null, 2);
            pre.textContent = pretty;
            out.classList.add('visible', data.ok ? 'ok' : 'err');
            out.dataset.copyText = pretty;
        } catch (e) {
            pre.textContent = String(e);
            out.classList.add('visible', 'err');
            out.dataset.copyText = pre.textContent;
        } finally {
            btn.disabled = false;
            btn.classList.remove('busy');
            btn.textContent = 'Run';
        }
    }

    function copyResponse(btn) {
        const out = btn.closest('.out');
        const pre = out.querySelector('pre');
        const t = (out.dataset.copyText || (pre && pre.textContent) || '').trim();
        if (!t) return;

        function done() {
            btn.textContent = 'Copied!';
            setTimeout(function () { btn.textContent = 'Copy response'; }, 1500);
        }

        // Clipboard API only works in secure contexts (HTTPS or localhost); otherwise use textarea fallback.
        if (navigator.clipboard && navigator.clipboard.writeText && window.isSecureContext) {
            navigator.clipboard.writeText(t).then(done).catch(function () {
                fallbackCopy(t, btn, done);
            });
        } else {
            fallbackCopy(t, btn, done);
        }
    }

    function fallbackCopy(text, btn, done) {
        const ta = document.createElement('textarea');
        ta.value = text;
        ta.setAttribute('readonly', '');
        ta.style.cssText = 'position:fixed;left:0;top:0;width:1px;height:1px;padding:0;margin:0;border:none;outline:none;opacity:0;';
        document.body.appendChild(ta);
        ta.focus();
        ta.select();
        try {
            ta.setSelectionRange(0, text.length);
        } catch (e) {}
        var ok = false;
        try {
            ok = document.execCommand('copy');
        } catch (e) {}
        document.body.removeChild(ta);
        if (ok && typeof done === 'function') {
            done();
        } else {
            alert('Could not copy automatically. Select the response text in the box above, then press Ctrl+C (Cmd+C on Mac).');
        }
    }

    function escHtml(s) {
        if (s === undefined || s === null) return '';
        const d = document.createElement('div');
        d.textContent = String(s);
        return d.innerHTML;
    }

    function buildUI(q) {
        root.innerHTML = '';
        const ql = (q || '').toLowerCase().trim();
        let methodCount = 0;
        const clients = Object.keys(manifest).sort();
        for (const resource of clients) {
            const methods = manifest[resource];
            const filteredMethods = methods.filter(function (m) {
                if (!ql) return true;
                if (resource.toLowerCase().indexOf(ql) !== -1) return true;
                if (m.name.toLowerCase().indexOf(ql) !== -1) return true;
                return false;
            });
            if (filteredMethods.length === 0) continue;

            const det = document.createElement('details');
            det.className = 'client';
            det.open = !!ql;
            const sum = document.createElement('summary');
            sum.textContent = resource + ' (' + filteredMethods.length + ' methods)';
            det.appendChild(sum);

            for (const m of filteredMethods) {
                methodCount++;
                const div = document.createElement('div');
                div.className = 'method';
                const head = document.createElement('div');
                head.className = 'method-head';
                const nameRow = document.createElement('div');
                nameRow.style.cssText = 'display:flex;flex-wrap:wrap;gap:0.5rem;align-items:center;width:100%;';
                const span = document.createElement('span');
                span.className = 'method-name';
                span.textContent = m.name + '()';
                const runBtn = document.createElement('button');
                runBtn.type = 'button';
                runBtn.className = 'method-run';
                runBtn.textContent = 'Run';
                nameRow.appendChild(span);
                nameRow.appendChild(runBtn);
                head.appendChild(nameRow);
                if (m.http && m.path) {
                    const meta = document.createElement('div');
                    meta.className = 'method-meta';
                    meta.innerHTML = '<code>' + escHtml(m.http) + '</code> · <code>' + escHtml(m.path) + '</code>';
                    head.appendChild(meta);
                }
                div.appendChild(head);

                const desc = document.createElement('p');
                desc.className = 'method-desc';
                if (m.summary) {
                    desc.innerHTML = '<strong>' + escHtml(m.summary) + '</strong>';
                } else {
                    desc.textContent = 'No API summary for this method in demo/includes/method_summaries.json.';
                }
                div.appendChild(desc);

                if (m.detail) {
                    const det = document.createElement('div');
                    det.className = 'method-detail';
                    det.textContent = m.detail;
                    div.appendChild(det);
                }

                for (const p of m.params) {
                    const row = document.createElement('div');
                    row.className = 'param-row';
                    const lab = document.createElement('label');
                    lab.textContent = p.name;
                    lab.setAttribute('for', 'i_' + resource + '_' + m.name + '_' + p.name);
                    let inp;
                    if (p.array) {
                        inp = document.createElement('textarea');
                        inp.textContent = defaultJsonForParam(p);
                    } else {
                        inp = document.createElement('input');
                        inp.type = 'text';
                        if (p.optional && p.default !== undefined && p.default !== null && !p.array) {
                            inp.placeholder = String(p.default);
                        }
                    }
                    inp.id = 'i_' + resource + '_' + m.name + '_' + p.name;
                    inp.dataset.p = p.name;
                    const hint = document.createElement('span');
                    hint.style.gridColumn = '1 / -1';
                    hint.style.fontSize = '0.72rem';
                    hint.style.color = '#64748b';
                    hint.textContent = p.type + (p.optional ? ' · optional' : ' · required');
                    row.appendChild(lab);
                    row.appendChild(inp);
                    row.appendChild(hint);
                    div.appendChild(row);
                }

                const out = document.createElement('div');
                out.className = 'out';
                const pre = document.createElement('pre');
                const copyBtn = document.createElement('button');
                copyBtn.type = 'button';
                copyBtn.className = 'copy-btn';
                copyBtn.textContent = 'Copy response';
                copyBtn.onclick = function () { copyResponse(copyBtn); };
                out.appendChild(pre);
                out.appendChild(copyBtn);
                div.appendChild(out);

                runBtn.onclick = function () { runMethod(resource, m, div); };
                det.appendChild(div);
            }
            root.appendChild(det);
        }
        countLine.textContent = methodCount + ' methods shown' + (ql ? ' (filtered)' : '') + ' · ' + clients.length + ' clients total';
    }

    filterEl.addEventListener('input', function () {
        buildUI(filterEl.value);
    });
    buildUI('');
})();
    </script>
    <p class="wrap footer-hint">Run locally: <code>php -S 127.0.0.1:8080 -t demo</code></p>
</body>
</html>

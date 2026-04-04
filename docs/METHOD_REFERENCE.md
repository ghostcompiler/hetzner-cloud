# Hetzner Cloud API — method reference

Summaries and short descriptions are taken from the official [Hetzner Cloud OpenAPI spec](https://docs.hetzner.cloud/cloud.spec.json). Use this alongside the [interactive demo](../demo/) and [API docs](https://docs.hetzner.cloud/reference/cloud).

## `actions` (ActionsClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `getAction()` | GET | `/actions/{id}` | Get an Action |
| `getActions()` | GET | `/actions` | Get multiple Actions |

### Details

- **`getAction()`** — Get an Action
  - Returns a specific Action object.

- **`getActions()`** — Get multiple Actions
  - Returns multiple Action objects specified by the `id` parameter. **Note**: This endpoint previously allowed listing all actions in the project. This functionality was deprecated in July 2023 and removed on 30 January 2025. - Announcement: https://docs.hetzner.cloud/changelog#2023-07-20-actions-list-endpoint-is-deprecated - Removal:…

## `certificates` (CertificatesClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `createCertificate()` | POST | `/certificates` | Create a Certificate |
| `deleteCertificate()` | DELETE | `/certificates/{id}` | Delete a Certificate |
| `getCertificate()` | GET | `/certificates/{id}` | Get a Certificate |
| `getCertificateAction()` | GET | `/certificates/{id}/actions/{action_id}` | Get an Action for a Certificate |
| `getCertificatesAction()` | GET | `/certificates/actions/{id}` | Get an Action |
| `listCertificateActions()` | GET | `/certificates/{id}/actions` | List Actions for a Certificate |
| `listCertificates()` | GET | `/certificates` | List Certificates |
| `listCertificatesActions()` | GET | `/certificates/actions` | List Actions |
| `retryCertificate()` | POST | `/certificates/{id}/actions/retry` | Retry Issuance or Renewal |
| `updateCertificate()` | PUT | `/certificates/{id}` | Update a Certificate |

### Details

- **`createCertificate()`** — Create a Certificate
  - Creates a new Certificate. The default type **uploaded** allows for uploading your existing `certificate` and `private_key` in PEM format. You have to monitor its expiration date and handle renewal yourself. In contrast, type **managed** requests a new Certificate from *Let's Encrypt* for the specified `domain_names`. Only domains managed by *Hetzner DNS* are supported. We handle renewal and…

- **`deleteCertificate()`** — Delete a Certificate
  - Deletes a Certificate.

- **`getCertificate()`** — Get a Certificate
  - Gets a specific Certificate object.

- **`getCertificateAction()`** — Get an Action for a Certificate
  - Returns a specific Action for a Certificate. Only type `managed` Certificates have Actions.

- **`getCertificatesAction()`** — Get an Action
  - Returns a specific Action object.

- **`listCertificateActions()`** — List Actions for a Certificate
  - Returns all Action objects for a Certificate. You can sort the results by using the `sort` URI parameter, and filter them with the `status` parameter. Only type `managed` Certificates can have Actions. For type `uploaded` Certificates the `actions` key will always contain an empty array.

- **`listCertificates()`** — List Certificates
  - Returns all Certificate objects.

- **`listCertificatesActions()`** — List Actions
  - Returns all Action objects. You can `sort` the results by using the sort URI parameter, and filter them with the `status` and `id` parameter.

- **`retryCertificate()`** — Retry Issuance or Renewal
  - Retry a failed Certificate issuance or renewal. Only applicable if the type of the Certificate is `managed` and the issuance or renewal status is `failed`. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| \| `caa_record_does_not_allow_ca` \| CAA record does not allow certificate authority \| \| \| `ca_dns_validation_failed` \| Certificate Authority: DNS validation…

- **`updateCertificate()`** — Update a Certificate
  - Updates the Certificate properties. Note: if the Certificate object changes during the request, the response will be a “conflict” error.

## `datacenters` (DatacentersClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `getDatacenter()` | GET | `/datacenters/{id}` | Get a Data Center |
| `listDatacenters()` | GET | `/datacenters` | List Data Centers |

### Details

- **`getDatacenter()`** — Get a Data Center
  - Returns a single Data Center.

- **`listDatacenters()`** — List Data Centers
  - Returns all Data Centers.

## `firewalls` (FirewallsClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `applyFirewallToResources()` | POST | `/firewalls/{id}/actions/apply_to_resources` | Apply to Resources |
| `createFirewall()` | POST | `/firewalls` | Create a Firewall |
| `deleteFirewall()` | DELETE | `/firewalls/{id}` | Delete a Firewall |
| `getFirewall()` | GET | `/firewalls/{id}` | Get a Firewall |
| `getFirewallAction()` | GET | `/firewalls/{id}/actions/{action_id}` | Get an Action for a Firewall |
| `getFirewallsAction()` | GET | `/firewalls/actions/{id}` | Get an Action |
| `listFirewallActions()` | GET | `/firewalls/{id}/actions` | List Actions for a Firewall |
| `listFirewalls()` | GET | `/firewalls` | List Firewalls |
| `listFirewallsActions()` | GET | `/firewalls/actions` | List Actions |
| `removeFirewallFromResources()` | POST | `/firewalls/{id}/actions/remove_from_resources` | Remove from Resources |
| `setFirewallRules()` | POST | `/firewalls/{id}/actions/set_rules` | Set Rules |
| `updateFirewall()` | PUT | `/firewalls/{id}` | Update a Firewall |

### Details

- **`applyFirewallToResources()`** — Apply to Resources
  - Applies a Firewall to multiple resources. Supported resources: - Servers (with a public network interface) - Label Selectors A Server can be applied to a maximum of 5 Firewalls. This limit applies to Servers applied via a matching Label Selector as well. Updates to resources matching or no longer matching a Label Selector can take up to a few seconds to be processed. A Firewall is applied to a…

- **`createFirewall()`** — Create a Firewall
  - Create a Firewall. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `server_already_added` \| The Server was applied more than once. \| \| `422` \| `incompatible_network_type` \| The resources network type is not supported by Firewalls. \| \| `422` \| `firewall_resource_not_found` \| The resource the Firewall should be attached to was not found. \|

- **`deleteFirewall()`** — Delete a Firewall
  - Deletes the Firewall. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `resource_in_use` \| Firewall still applied to a resource \|

- **`getFirewall()`** — Get a Firewall
  - Returns a single Firewall.

- **`getFirewallAction()`** — Get an Action for a Firewall
  - Returns a specific Action for a Firewall.

- **`getFirewallsAction()`** — Get an Action
  - Returns the specific Action.

- **`listFirewallActions()`** — List Actions for a Firewall
  - Returns all Actions for the Firewall. Use the provided URI parameters to modify the result.

- **`listFirewalls()`** — List Firewalls
  - Returns all Firewalls. Use the provided URI parameters to modify the result.

- **`listFirewallsActions()`** — List Actions
  - Returns all Actions for Firewalls. Use the provided URI parameters to modify the result.

- **`removeFirewallFromResources()`** — Remove from Resources
  - Removes a Firewall from multiple resources. Supported resources: - Servers (with a public network interface) A Firewall is removed from a resource once the related Action with command `remove_firewall` successfully finished. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `404` \| `firewall_resource_not_found` \| The resource the Firewall should be removed from…

- **`setFirewallRules()`** — Set Rules
  - Set the rules of a Firewall. Overwrites the existing rules with the given ones. Pass an empty array to remove all rules. Rules are limited to 50 entries per Firewall and 500 effective rules.

- **`updateFirewall()`** — Update a Firewall
  - Update a Firewall. In case of a parallel running change on the Firewall a `conflict` error will be returned.

## `floatingIps` (FloatingIpsClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `assignFloatingIp()` | POST | `/floating_ips/{id}/actions/assign` | Assign a Floating IP to a Server |
| `changeFloatingIpDnsPtr()` | POST | `/floating_ips/{id}/actions/change_dns_ptr` | Change reverse DNS records for a Floating IP |
| `changeFloatingIpProtection()` | POST | `/floating_ips/{id}/actions/change_protection` | Change Floating IP Protection |
| `createFloatingIp()` | POST | `/floating_ips` | Create a Floating IP |
| `deleteFloatingIp()` | DELETE | `/floating_ips/{id}` | Delete a Floating IP |
| `getFloatingIp()` | GET | `/floating_ips/{id}` | Get a Floating IP |
| `getFloatingIpAction()` | GET | `/floating_ips/{id}/actions/{action_id}` | Get an Action for a Floating IP |
| `getFloatingIpsAction()` | GET | `/floating_ips/actions/{id}` | Get an Action |
| `listFloatingIpActions()` | GET | `/floating_ips/{id}/actions` | List Actions for a Floating IP |
| `listFloatingIps()` | GET | `/floating_ips` | List Floating IPs |
| `listFloatingIpsActions()` | GET | `/floating_ips/actions` | List Actions |
| `unassignFloatingIp()` | POST | `/floating_ips/{id}/actions/unassign` | Unassign a Floating IP |
| `updateFloatingIp()` | PUT | `/floating_ips/{id}` | Update a Floating IP |

### Details

- **`assignFloatingIp()`** — Assign a Floating IP to a Server
  - Assigns a Floating IP to a Server. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `floating_ip_assigned` \| The Floating IP is already assigned \|

- **`changeFloatingIpDnsPtr()`** — Change reverse DNS records for a Floating IP
  - Change the reverse DNS records for this Floating IP. Allows to modify the PTR records set for the IP address.

- **`changeFloatingIpProtection()`** — Change Floating IP Protection
  - Changes the protection settings configured for the Floating IP.

- **`createFloatingIp()`** — Create a Floating IP
  - Create a Floating IP. Provide the `server` attribute to assign the Floating IP to that server or provide a `home_location` to locate the Floating IP at. Note that the Floating IP can be assigned to a Server in any Location later on. For optimal routing it is advised to use the Floating IP in the same Location it was created in.

- **`deleteFloatingIp()`** — Delete a Floating IP
  - Deletes a Floating IP. If assigned to a Server the Floating IP will be unassigned automatically until 1 May 2026. After this date, the Floating IP needs to be unassigned before it can be deleted. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `must_be_unassigned` \| Error when IP is still assigned to a Resource. This error will appear as of 1 May…

- **`getFloatingIp()`** — Get a Floating IP
  - Returns a single Floating IP.

- **`getFloatingIpAction()`** — Get an Action for a Floating IP
  - Returns a specific Action for a Floating IP.

- **`getFloatingIpsAction()`** — Get an Action
  - Returns a single Action.

- **`listFloatingIpActions()`** — List Actions for a Floating IP
  - Lists Actions for a Floating IP. Use the provided URI parameters to modify the result.

- **`listFloatingIps()`** — List Floating IPs
  - List multiple Floating IPs. Use the provided URI parameters to modify the result.

- **`listFloatingIpsActions()`** — List Actions
  - Lists multiple Actions. Use the provided URI parameters to modify the result.

- **`unassignFloatingIp()`** — Unassign a Floating IP
  - Unassigns a Floating IP. Results in the IP being unreachable. Can be assigned to another resource again.

- **`updateFloatingIp()`** — Update a Floating IP
  - Update a Floating IP.

## `images` (ImagesClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `changeImageProtection()` | POST | `/images/{id}/actions/change_protection` | Change Image Protection |
| `deleteImage()` | DELETE | `/images/{id}` | Delete an Image |
| `getImage()` | GET | `/images/{id}` | Get an Image |
| `getImageAction()` | GET | `/images/{id}/actions/{action_id}` | Get an Action for an Image |
| `getImagesAction()` | GET | `/images/actions/{id}` | Get an Action |
| `listImageActions()` | GET | `/images/{id}/actions` | List Actions for an Image |
| `listImages()` | GET | `/images` | List Images |
| `listImagesActions()` | GET | `/images/actions` | List Actions |
| `updateImage()` | PUT | `/images/{id}` | Update an Image |

### Details

- **`changeImageProtection()`** — Change Image Protection
  - Changes the protection configuration of the Image. Can only be used on snapshots.

- **`deleteImage()`** — Delete an Image
  - Deletes an Image. Only Images of type `snapshot` and `backup` can be deleted.

- **`getImage()`** — Get an Image
  - Returns a specific Image object.

- **`getImageAction()`** — Get an Action for an Image
  - Returns a specific Action for an Image.

- **`getImagesAction()`** — Get an Action
  - Returns a specific Action object.

- **`listImageActions()`** — List Actions for an Image
  - Returns all Action objects for an Image. You can sort the results by using the `sort` URI parameter, and filter them with the `status` parameter.

- **`listImages()`** — List Images
  - Returns all Image objects. You can select specific Image types only and sort the results by using URI parameters.

- **`listImagesActions()`** — List Actions
  - Returns all Action objects. You can `sort` the results by using the sort URI parameter, and filter them with the `status` and `id` parameter.

- **`updateImage()`** — Update an Image
  - Updates the Image. You may change the description, convert a Backup Image to a Snapshot Image or change the Image labels. Only Images of type `snapshot` and `backup` can be updated.

## `isos` (IsosClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `getIso()` | GET | `/isos/{id}` | Get an ISO |
| `listIsos()` | GET | `/isos` | List ISOs |

### Details

- **`getIso()`** — Get an ISO
  - Returns a specific ISO object.

- **`listIsos()`** — List ISOs
  - Returns all available ISO objects.

## `loadBalancerTypes` (LoadBalancerTypesClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `getLoadBalancerType()` | GET | `/load_balancer_types/{id}` | Get a Load Balancer Type |
| `listLoadBalancerTypes()` | GET | `/load_balancer_types` | List Load Balancer Types |

### Details

- **`getLoadBalancerType()`** — Get a Load Balancer Type
  - Gets a specific Load Balancer type object.

- **`listLoadBalancerTypes()`** — List Load Balancer Types
  - Gets all Load Balancer type objects.

## `loadBalancers` (LoadBalancersClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `addLoadBalancerService()` | POST | `/load_balancers/{id}/actions/add_service` | Add Service |
| `addLoadBalancerTarget()` | POST | `/load_balancers/{id}/actions/add_target` | Add Target |
| `attachLoadBalancerToNetwork()` | POST | `/load_balancers/{id}/actions/attach_to_network` | Attach a Load Balancer to a Network |
| `changeLoadBalancerAlgorithm()` | POST | `/load_balancers/{id}/actions/change_algorithm` | Change Algorithm |
| `changeLoadBalancerDnsPtr()` | POST | `/load_balancers/{id}/actions/change_dns_ptr` | Change reverse DNS entry for this Load Balancer |
| `changeLoadBalancerProtection()` | POST | `/load_balancers/{id}/actions/change_protection` | Change Load Balancer Protection |
| `changeLoadBalancerType()` | POST | `/load_balancers/{id}/actions/change_type` | Change the Type of a Load Balancer |
| `createLoadBalancer()` | POST | `/load_balancers` | Create a Load Balancer |
| `deleteLoadBalancer()` | DELETE | `/load_balancers/{id}` | Delete a Load Balancer |
| `deleteLoadBalancerService()` | POST | `/load_balancers/{id}/actions/delete_service` | Delete Service |
| `detachLoadBalancerFromNetwork()` | POST | `/load_balancers/{id}/actions/detach_from_network` | Detach a Load Balancer from a Network |
| `disableLoadBalancerPublicInterface()` | POST | `/load_balancers/{id}/actions/disable_public_interface` | Disable the public interface of a Load Balancer |
| `enableLoadBalancerPublicInterface()` | POST | `/load_balancers/{id}/actions/enable_public_interface` | Enable the public interface of a Load Balancer |
| `getLoadBalancer()` | GET | `/load_balancers/{id}` | Get a Load Balancer |
| `getLoadBalancerAction()` | GET | `/load_balancers/{id}/actions/{action_id}` | Get an Action for a Load Balancer |
| `getLoadBalancerMetrics()` | GET | `/load_balancers/{id}/metrics` | Get Metrics for a LoadBalancer |
| `getLoadBalancersAction()` | GET | `/load_balancers/actions/{id}` | Get an Action |
| `listLoadBalancerActions()` | GET | `/load_balancers/{id}/actions` | List Actions for a Load Balancer |
| `listLoadBalancers()` | GET | `/load_balancers` | List Load Balancers |
| `listLoadBalancersActions()` | GET | `/load_balancers/actions` | List Actions |
| `removeLoadBalancerTarget()` | POST | `/load_balancers/{id}/actions/remove_target` | Remove Target |
| `updateLoadBalancer()` | PUT | `/load_balancers/{id}` | Update a Load Balancer |
| `updateLoadBalancerService()` | POST | `/load_balancers/{id}/actions/update_service` | Update Service |

### Details

- **`addLoadBalancerService()`** — Add Service
  - Adds a service to a Load Balancer. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `412` \| `source_port_already_used` \| The source port you are trying to add is already in use \|

- **`addLoadBalancerTarget()`** — Add Target
  - Adds a target to a Load Balancer. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `ip_not_in_vswitch_subnet` \| The IP you are trying to add does not belong to the vswitch subnet of the attached network \| \| `422` \| `ip_not_owned` \| The IP you are trying to add as a target is not owned by the Project owner \| \| `422` \|…

- **`attachLoadBalancerToNetwork()`** — Attach a Load Balancer to a Network
  - Attach a Load Balancer to a Network. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `load_balancer_already_attached` \| The Load Balancer is already attached to a network \| \| `422` \| `ip_not_available` \| The provided Network IP is not available \| \| `422` \| `no_subnet_available` \| No Subnet or IP is available for the Load Balancer within the network \|

- **`changeLoadBalancerAlgorithm()`** — Change Algorithm
  - Change the algorithm that determines to which target new requests are sent.

- **`changeLoadBalancerDnsPtr()`** — Change reverse DNS entry for this Load Balancer
  - Changes the hostname that will appear when getting the hostname belonging to the public IPs (IPv4 and IPv6) of this Load Balancer. Floating IPs assigned to the Server are not affected by this.

- **`changeLoadBalancerProtection()`** — Change Load Balancer Protection
  - Changes the protection configuration of a Load Balancer.

- **`changeLoadBalancerType()`** — Change the Type of a Load Balancer
  - Changes the type (Max Services, Max Targets and Max Connections) of a Load Balancer. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `invalid_load_balancer_type` \| The Load Balancer type does not fit for the given Load Balancer \|

- **`createLoadBalancer()`** — Create a Load Balancer
  - Creates a Load Balancer. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `412` \| `source_port_already_used` \| The source port you are trying to add is already in use \| \| `422` \| `ip_not_owned` \| The IP is not owned by the owner of the project of the Load Balancer \| \| `422` \| `load_balancer_not_attached_to_network` \| The Load Balancer is not attached to a…

- **`deleteLoadBalancer()`** — Delete a Load Balancer
  - Deletes a Load Balancer.

- **`deleteLoadBalancerService()`** — Delete Service
  - Delete a service of a Load Balancer.

- **`detachLoadBalancerFromNetwork()`** — Detach a Load Balancer from a Network
  - Detaches a Load Balancer from a network.

- **`disableLoadBalancerPublicInterface()`** — Disable the public interface of a Load Balancer
  - Disable the public interface of a Load Balancer. The Load Balancer will be not accessible from the internet via its public IPs. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `load_balancer_not_attached_to_network` \| The Load Balancer is not attached to a network \| \| `422` \| `targets_without_use_private_ip` \| The Load Balancer has targets that use…

- **`enableLoadBalancerPublicInterface()`** — Enable the public interface of a Load Balancer
  - Enable the public interface of a Load Balancer. The Load Balancer will be accessible from the internet via its public IPs.

- **`getLoadBalancer()`** — Get a Load Balancer
  - Gets a specific Load Balancer object.

- **`getLoadBalancerAction()`** — Get an Action for a Load Balancer
  - Returns a specific Action for a Load Balancer.

- **`getLoadBalancerMetrics()`** — Get Metrics for a LoadBalancer
  - You must specify the type of metric to get: `open_connections`, `connections_per_second`, `requests_per_second` or `bandwidth`. You can also specify more than one type by comma separation, e.g. `requests_per_second,bandwidth`. Depending on the type you will get different time series data: \|Type \| Timeseries \| Unit \| Description \| \|---- \|------------\|------\|-------------\| \| open_connections \|…

- **`getLoadBalancersAction()`** — Get an Action
  - Returns a specific Action object.

- **`listLoadBalancerActions()`** — List Actions for a Load Balancer
  - Returns all Action objects for a Load Balancer. You can sort the results by using the `sort` URI parameter, and filter them with the `status` parameter.

- **`listLoadBalancers()`** — List Load Balancers
  - Gets all existing Load Balancers that you have available.

- **`listLoadBalancersActions()`** — List Actions
  - Returns all Action objects. You can `sort` the results by using the sort URI parameter, and filter them with the `status` and `id` parameter.

- **`removeLoadBalancerTarget()`** — Remove Target
  - Removes a target from a Load Balancer.

- **`updateLoadBalancer()`** — Update a Load Balancer
  - Updates a Load Balancer. You can update a Load Balancer’s name and a Load Balancer’s labels. Note: if the Load Balancer object changes during the request, the response will be a “conflict” error.

- **`updateLoadBalancerService()`** — Update Service
  - Updates a Load Balancer Service. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `source_port_already_used` \| The source port you are trying to add is already in use \|

## `locations` (LocationsClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `getLocation()` | GET | `/locations/{id}` | Get a Location |
| `listLocations()` | GET | `/locations` | List Locations |

### Details

- **`getLocation()`** — Get a Location
  - Returns a Location.

- **`listLocations()`** — List Locations
  - Returns all Locations.

## `networks` (NetworksClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `addNetworkRoute()` | POST | `/networks/{id}/actions/add_route` | Add a route to a Network |
| `addNetworkSubnet()` | POST | `/networks/{id}/actions/add_subnet` | Add a subnet to a Network |
| `changeNetworkIpRange()` | POST | `/networks/{id}/actions/change_ip_range` | Change IP range of a Network |
| `changeNetworkProtection()` | POST | `/networks/{id}/actions/change_protection` | Change Network Protection |
| `createNetwork()` | POST | `/networks` | Create a Network |
| `deleteNetwork()` | DELETE | `/networks/{id}` | Delete a Network |
| `deleteNetworkRoute()` | POST | `/networks/{id}/actions/delete_route` | Delete a route from a Network |
| `deleteNetworkSubnet()` | POST | `/networks/{id}/actions/delete_subnet` | Delete a subnet from a Network |
| `getNetwork()` | GET | `/networks/{id}` | Get a Network |
| `getNetworkAction()` | GET | `/networks/{id}/actions/{action_id}` | Get an Action for a Network |
| `getNetworksAction()` | GET | `/networks/actions/{id}` | Get an Action |
| `listNetworkActions()` | GET | `/networks/{id}/actions` | List Actions for a Network |
| `listNetworks()` | GET | `/networks` | List Networks |
| `listNetworksActions()` | GET | `/networks/actions` | List Actions |
| `updateNetwork()` | PUT | `/networks/{id}` | Update a Network |

### Details

- **`addNetworkRoute()`** — Add a route to a Network
  - Adds a route entry to a Network. If a change is currently being performed on this Network, a error response with code `conflict` will be returned.

- **`addNetworkSubnet()`** — Add a subnet to a Network
  - Adds a new subnet to the Network. If the subnet `ip_range` is not provided, the first available `/24` IP range will be used. If a change is currently being performed on this Network, a error response with code `conflict` will be returned.

- **`changeNetworkIpRange()`** — Change IP range of a Network
  - Changes the IP range of a Network. The following restrictions apply to changing the IP range: - IP ranges can only be extended and never shrunk. - IPs can only be added to the end of the existing range, therefore only the netmask is allowed to be changed. To update the routes on the connected Servers, they need to be rebooted or the routes to be updated manually. For example if the Network has a…

- **`changeNetworkProtection()`** — Change Network Protection
  - Changes the protection settings of a Network. If a change is currently being performed on this Network, a error response with code `conflict` will be returned.

- **`createNetwork()`** — Create a Network
  - Creates a Network. The provided `ip_range` can only be extended later on, but not reduced. Subnets can be added now or later on using the add subnet action. If you do not specify an `ip_range` for the subnet the first available /24 range will be used. Routes can be added now or later by using the add route action.

- **`deleteNetwork()`** — Delete a Network
  - Deletes a Network. Attached resources will be detached automatically.

- **`deleteNetworkRoute()`** — Delete a route from a Network
  - Delete a route entry from a Network. If a change is currently being performed on this Network, a error response with code `conflict` will be returned.

- **`deleteNetworkSubnet()`** — Delete a subnet from a Network
  - Deletes a single subnet entry from a Network. Subnets containing attached resources can not be deleted, they must be detached beforehand. If a change is currently being performed on this Network, a error response with code `conflict` will be returned.

- **`getNetwork()`** — Get a Network
  - Get a specific Network.

- **`getNetworkAction()`** — Get an Action for a Network
  - Returns a specific Action for a Network.

- **`getNetworksAction()`** — Get an Action
  - Returns a single Action.

- **`listNetworkActions()`** — List Actions for a Network
  - Lists Actions for a Network. Use the provided URI parameters to modify the result.

- **`listNetworks()`** — List Networks
  - List multiple Networks. Use the provided URI parameters to modify the result.

- **`listNetworksActions()`** — List Actions
  - Lists multiple Actions. Use the provided URI parameters to modify the result.

- **`updateNetwork()`** — Update a Network
  - Update a Network. If a change is currently being performed on this Network, a error response with code `conflict` will be returned.

## `placementGroups` (PlacementGroupsClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `createPlacementGroup()` | POST | `/placement_groups` | Create a PlacementGroup |
| `deletePlacementGroup()` | DELETE | `/placement_groups/{id}` | Delete a PlacementGroup |
| `getPlacementGroup()` | GET | `/placement_groups/{id}` | Get a PlacementGroup |
| `listPlacementGroups()` | GET | `/placement_groups` | List Placement Groups |
| `updatePlacementGroup()` | PUT | `/placement_groups/{id}` | Update a PlacementGroup |

### Details

- **`createPlacementGroup()`** — Create a PlacementGroup
  - Creates a new Placement Group.

- **`deletePlacementGroup()`** — Delete a PlacementGroup
  - Deletes a Placement Group.

- **`getPlacementGroup()`** — Get a PlacementGroup
  - Gets a specific Placement Group object.

- **`listPlacementGroups()`** — List Placement Groups
  - Returns all Placement Group objects.

- **`updatePlacementGroup()`** — Update a PlacementGroup
  - Updates the Placement Group properties. Note: if the Placement Group object changes during the request, the response will be a “conflict” error.

## `pricing` (PricingClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `getPricing()` | GET | `/pricing` | Get all prices |

### Details

- **`getPricing()`** — Get all prices
  - Returns prices for all resources available on the platform. VAT and currency of the Project owner are used for calculations. Both net and gross prices are included in the response.

## `primaryIps` (PrimaryIpsClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `assignPrimaryIp()` | POST | `/primary_ips/{id}/actions/assign` | Assign a Primary IP to a resource |
| `changePrimaryIpDnsPtr()` | POST | `/primary_ips/{id}/actions/change_dns_ptr` | Change reverse DNS records for a Primary IP |
| `changePrimaryIpProtection()` | POST | `/primary_ips/{id}/actions/change_protection` | Change Primary IP Protection |
| `createPrimaryIp()` | POST | `/primary_ips` | Create a Primary IP |
| `deletePrimaryIp()` | DELETE | `/primary_ips/{id}` | Delete a Primary IP |
| `getPrimaryIp()` | GET | `/primary_ips/{id}` | Get a Primary IP |
| `getPrimaryIpAction()` | GET | `/primary_ips/{id}/actions/{action_id}` | Get an Action for a Primary IP |
| `getPrimaryIpsAction()` | GET | `/primary_ips/actions/{id}` | Get an Action |
| `listPrimaryIpActions()` | GET | `/primary_ips/{id}/actions` | List Actions for a Primary IP |
| `listPrimaryIps()` | GET | `/primary_ips` | List Primary IPs |
| `listPrimaryIpsActions()` | GET | `/primary_ips/actions` | List Actions |
| `unassignPrimaryIp()` | POST | `/primary_ips/{id}/actions/unassign` | Unassign a Primary IP from a resource |
| `updatePrimaryIp()` | PUT | `/primary_ips/{id}` | Update a Primary IP |

### Details

- **`assignPrimaryIp()`** — Assign a Primary IP to a resource
  - Assign a Primary IP to a resource. A Server can only have one Primary IP of type `ipv4` and one of type `ipv6` assigned. If you need more IPs use Floating IPs. A Server must be powered off (status `off`) in order for this operation to succeed. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `server_not_stopped` \| The Server is running, but needs to be…

- **`changePrimaryIpDnsPtr()`** — Change reverse DNS records for a Primary IP
  - Change the reverse DNS records for this Primary IP. Allows to modify the PTR records set for the IP address.

- **`changePrimaryIpProtection()`** — Change Primary IP Protection
  - Changes the protection configuration of a Primary IP. A Primary IPs deletion protection can only be enabled if its `auto_delete` property is set to `false`.

- **`createPrimaryIp()`** — Create a Primary IP
  - Create a new Primary IP. Can optionally be assigned to a resource by providing an `assignee_id` and `assignee_type`. If not assigned to a resource the `location` key needs to be provided. This can be either the ID or the name of the Location this Primary IP shall be created in. A Primary IP can only be assigned to resource in the same Location later on. The `datacenter` key is deprecated in…

- **`deletePrimaryIp()`** — Delete a Primary IP
  - Deletes a Primary IP. The Server must be powered off (status `off`) in order for this operation to succeed. If assigned to a Server the Primary IP will be unassigned automatically until 1 May 2026. After this date, the Primary IP needs to be unassigned before it can be deleted. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `must_be_unassigned` \|…

- **`getPrimaryIp()`** — Get a Primary IP
  - Returns a Primary IP.

- **`getPrimaryIpAction()`** — Get an Action for a Primary IP
  - Returns a specific Action for a Primary IP.

- **`getPrimaryIpsAction()`** — Get an Action
  - Returns a single Action.

- **`listPrimaryIpActions()`** — List Actions for a Primary IP
  - Returns all Actions for a Primary IP. Use the provided URI parameters to modify the result.

- **`listPrimaryIps()`** — List Primary IPs
  - List multiple Primary IPs. Use the provided URI parameters to modify the result.

- **`listPrimaryIpsActions()`** — List Actions
  - Lists multiple Actions. Use the provided URI parameters to modify the result.

- **`unassignPrimaryIp()`** — Unassign a Primary IP from a resource
  - Unassign a Primary IP from a resource. A Server must be powered off (status `off`) in order for this operation to succeed. A Server requires at least one network interface (public or private) to be powered on. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `server_not_stopped` \| The Server is running, but needs to be powered off \| \| `422` \|…

- **`updatePrimaryIp()`** — Update a Primary IP
  - Update a Primary IP. If another change is concurrently performed on this Primary IP, a error response with code `conflict` will be returned.

## `serverTypes` (ServerTypesClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `getServerType()` | GET | `/server_types/{id}` | Get a Server Type |
| `listServerTypes()` | GET | `/server_types` | List Server Types |

### Details

- **`getServerType()`** — Get a Server Type
  - Gets a specific Server type object.

- **`listServerTypes()`** — List Server Types
  - Gets all Server type objects.

## `servers` (ServersClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `addServerToPlacementGroup()` | POST | `/servers/{id}/actions/add_to_placement_group` | Add a Server to a Placement Group |
| `attachServerIso()` | POST | `/servers/{id}/actions/attach_iso` | Attach an ISO to a Server |
| `attachServerToNetwork()` | POST | `/servers/{id}/actions/attach_to_network` | Attach a Server to a Network |
| `changeServerAliasIps()` | POST | `/servers/{id}/actions/change_alias_ips` | Change alias IPs of a Network |
| `changeServerDnsPtr()` | POST | `/servers/{id}/actions/change_dns_ptr` | Change reverse DNS entry for this Server |
| `changeServerProtection()` | POST | `/servers/{id}/actions/change_protection` | Change Server Protection |
| `changeServerType()` | POST | `/servers/{id}/actions/change_type` | Change the Type of a Server |
| `createServer()` | POST | `/servers` | Create a Server |
| `createServerImage()` | POST | `/servers/{id}/actions/create_image` | Create Image from a Server |
| `deleteServer()` | DELETE | `/servers/{id}` | Delete a Server |
| `detachServerFromNetwork()` | POST | `/servers/{id}/actions/detach_from_network` | Detach a Server from a Network |
| `detachServerIso()` | POST | `/servers/{id}/actions/detach_iso` | Detach an ISO from a Server |
| `disableServerBackup()` | POST | `/servers/{id}/actions/disable_backup` | Disable Backups for a Server |
| `disableServerRescue()` | POST | `/servers/{id}/actions/disable_rescue` | Disable Rescue Mode for a Server |
| `enableServerBackup()` | POST | `/servers/{id}/actions/enable_backup` | Enable and Configure Backups for a Server |
| `enableServerRescue()` | POST | `/servers/{id}/actions/enable_rescue` | Enable Rescue Mode for a Server |
| `getServer()` | GET | `/servers/{id}` | Get a Server |
| `getServerAction()` | GET | `/servers/{id}/actions/{action_id}` | Get an Action for a Server |
| `getServerMetrics()` | GET | `/servers/{id}/metrics` | Get Metrics for a Server |
| `getServersAction()` | GET | `/servers/actions/{id}` | Get an Action |
| `listServerActions()` | GET | `/servers/{id}/actions` | List Actions for a Server |
| `listServers()` | GET | `/servers` | List Servers |
| `listServersActions()` | GET | `/servers/actions` | List Actions |
| `poweroffServer()` | POST | `/servers/{id}/actions/poweroff` | Power off a Server |
| `poweronServer()` | POST | `/servers/{id}/actions/poweron` | Power on a Server |
| `rebootServer()` | POST | `/servers/{id}/actions/reboot` | Soft-reboot a Server |
| `rebuildServer()` | POST | `/servers/{id}/actions/rebuild` | Rebuild a Server from an Image |
| `removeServerFromPlacementGroup()` | POST | `/servers/{id}/actions/remove_from_placement_group` | Remove from Placement Group |
| `requestServerConsole()` | POST | `/servers/{id}/actions/request_console` | Request Console for a Server |
| `resetServer()` | POST | `/servers/{id}/actions/reset` | Reset a Server |
| `resetServerPassword()` | POST | `/servers/{id}/actions/reset_password` | Reset root Password of a Server |
| `shutdownServer()` | POST | `/servers/{id}/actions/shutdown` | Shutdown a Server |
| `updateServer()` | PUT | `/servers/{id}` | Update a Server |

### Details

- **`addServerToPlacementGroup()`** — Add a Server to a Placement Group
  - Adds a Server to a Placement Group. Server must be powered off for this command to succeed. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `server_not_stopped` \| The action requires a stopped server \| \| `422` \| `already_in_placement_group` \| The server is already part of a placement group \|

- **`attachServerIso()`** — Attach an ISO to a Server
  - Attaches an ISO to a Server. The Server will immediately see it as a new disk. An already attached ISO will automatically be detached before the new ISO is attached. Servers with attached ISOs have a modified boot order: They will try to boot from the ISO first before falling back to hard disk.

- **`attachServerToNetwork()`** — Attach a Server to a Network
  - Attaches a Server to a network. This will complement the fixed public Server interface by adding an additional ethernet interface to the Server which is connected to the specified network. The Server will get an IP auto assigned from a subnet of type `server` in the same `network_zone`. Using the `alias_ips` attribute you can also define one or more additional IPs to the Servers. Please note…

- **`changeServerAliasIps()`** — Change alias IPs of a Network
  - Changes the alias IPs of an already attached Network. Note that the existing aliases for the specified Network will be replaced with these provided in the request body. So if you want to add an alias IP, you have to provide the existing ones from the Network plus the new alias IP in the request body.

- **`changeServerDnsPtr()`** — Change reverse DNS entry for this Server
  - Changes the hostname that will appear when getting the hostname belonging to the primary IPs (IPv4 and IPv6) of this Server. Floating IPs assigned to the Server are not affected by this.

- **`changeServerProtection()`** — Change Server Protection
  - Changes the protection configuration of the Server.

- **`changeServerType()`** — Change the Type of a Server
  - Changes the type (Cores, RAM and disk sizes) of a Server. Server must be powered off for this command to succeed. This copies the content of its disk, and starts it again. You can only migrate to Server types with the same `storage_type` and equal or bigger disks. Shrinking disks is not possible as it might destroy data. If the disk gets upgraded, the Server type can not be downgraded any more.…

- **`createServer()`** — Create a Server
  - Creates a new Server. Returns preliminary information about the Server as well as an Action that covers progress of creation. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `412` \| `primary_ip_version_mismatch` \| The specified Primary IP has the wrong IP Version \| \| `422` \| `placement_error` \| An error during the placement occurred \| \| `422` \|…

- **`createServerImage()`** — Create Image from a Server
  - Creates an Image (snapshot) from a Server by copying the contents of its disks. This creates a snapshot of the current state of the disk and copies it into an Image. If the Server is currently running you must make sure that its disk content is consistent. Otherwise, the created Image may not be readable. To make sure disk content is consistent, we recommend to shut down the Server prior to…

- **`deleteServer()`** — Delete a Server
  - Deletes a Server. This immediately removes the Server from your account, and it is no longer accessible. Any resources attached to the server (like Volumes, Primary IPs, Floating IPs, Firewalls, Placement Groups) are detached while the server is deleted.

- **`detachServerFromNetwork()`** — Detach a Server from a Network
  - Detaches a Server from a network. The interface for this network will vanish.

- **`detachServerIso()`** — Detach an ISO from a Server
  - Detaches an ISO from a Server. In case no ISO Image is attached to the Server, the status of the returned Action is immediately set to `success`.

- **`disableServerBackup()`** — Disable Backups for a Server
  - Disables the automatic backup option and deletes all existing Backups for a Server. No more additional charges for backups will be made. Caution: This immediately removes all existing backups for the Server!

- **`disableServerRescue()`** — Disable Rescue Mode for a Server
  - Disables the Hetzner Rescue System for a Server. This makes a Server start from its disks on next reboot. Rescue Mode is automatically disabled when you first boot into it or if you do not use it for 60 minutes. Disabling rescue mode will not reboot your Server — you will have to do this yourself.

- **`enableServerBackup()`** — Enable and Configure Backups for a Server
  - Enables and configures the automatic daily backup option for the Server. Enabling automatic backups will increase the price of the Server by 20%. In return, you will get seven slots where Images of type backup can be stored. Backups are automatically created daily.

- **`enableServerRescue()`** — Enable Rescue Mode for a Server
  - Enable the Hetzner Rescue System for this Server. The next time a Server with enabled rescue mode boots it will start a special minimal Linux distribution designed for repair and reinstall. In case a Server cannot boot on its own you can use this to access a Server’s disks. Rescue Mode is automatically disabled when you first boot into it or if you do not use it for 60 minutes. Enabling rescue…

- **`getServer()`** — Get a Server
  - Returns a specific Server object. The Server must exist inside the Project.

- **`getServerAction()`** — Get an Action for a Server
  - Returns a specific Action object for a Server.

- **`getServerMetrics()`** — Get Metrics for a Server
  - Get Metrics for specified Server. You must specify the type of metric to get: cpu, disk or network. You can also specify more than one type by comma separation, e.g. cpu,disk. Depending on the type you will get different time series data \| Type \| Timeseries \| Unit \| Description \| \|---------\|-------------------------\|-----------\|------------------------------------------------------\| \| cpu \| cpu…

- **`getServersAction()`** — Get an Action
  - Returns a specific Action object.

- **`listServerActions()`** — List Actions for a Server
  - Returns all Action objects for a Server. You can `sort` the results by using the sort URI parameter, and filter them with the `status` parameter.

- **`listServers()`** — List Servers
  - Returns all existing Server objects.

- **`listServersActions()`** — List Actions
  - Returns all Action objects. You can `sort` the results by using the sort URI parameter, and filter them with the `status` and `id` parameter.

- **`poweroffServer()`** — Power off a Server
  - Cuts power to the Server. This forcefully stops it without giving the Server operating system time to gracefully stop. May lead to data loss, equivalent to pulling the power cord. Power off should only be used when shutdown does not work.

- **`poweronServer()`** — Power on a Server
  - Starts a Server by turning its power on.

- **`rebootServer()`** — Soft-reboot a Server
  - Reboots a Server gracefully by sending an ACPI request. The Server operating system must support ACPI and react to the request, otherwise the Server will not reboot.

- **`rebuildServer()`** — Rebuild a Server from an Image
  - Rebuilds a Server overwriting its disk with the content of an Image, thereby **destroying all data** on the target Server The Image can either be one you have created earlier (`backup` or `snapshot` Image) or it can be a completely fresh `system` Image provided by us. You can get a list of all available Images with `GET /images`. Your Server will automatically be powered off before the rebuild…

- **`removeServerFromPlacementGroup()`** — Remove from Placement Group
  - Removes a Server from a Placement Group.

- **`requestServerConsole()`** — Request Console for a Server
  - Requests credentials for remote access via VNC over websocket to keyboard, monitor, and mouse for a Server. The provided URL is valid for 1 minute, after this period a new url needs to be created to connect to the Server. How long the connection is open after the initial connect is not subject to this timeout.

- **`resetServer()`** — Reset a Server
  - Cuts power to a Server and starts it again. This forcefully stops it without giving the Server operating system time to gracefully stop. This may lead to data loss, it’s equivalent to pulling the power cord and plugging it in again. Reset should only be used when reboot does not work.

- **`resetServerPassword()`** — Reset root Password of a Server
  - Resets the root password. Only works for Linux systems that are running the qemu guest agent. Server must be powered on (status `running`) in order for this operation to succeed. This will generate a new password for this Server and return it. If this does not succeed you can use the rescue system to netboot the Server and manually change your Server password by hand.

- **`shutdownServer()`** — Shutdown a Server
  - Shuts down a Server gracefully by sending an ACPI shutdown request. The Server operating system must support ACPI and react to the request, otherwise the Server will not shut down. Please note that the `action` status in this case only reflects whether the action was sent to the server. It does not mean that the server actually shut down successfully. If you need to ensure that the server is…

- **`updateServer()`** — Update a Server
  - Updates a Server. You can update a Server’s name and a Server’s labels. Please note that Server names must be unique per Project and valid hostnames as per RFC 1123 (i.e. may only contain letters, digits, periods, and dashes).

## `sshKeys` (SshKeysClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `createSshKey()` | POST | `/ssh_keys` | Create an SSH key |
| `deleteSshKey()` | DELETE | `/ssh_keys/{id}` | Delete an SSH key |
| `getSshKey()` | GET | `/ssh_keys/{id}` | Get a SSH key |
| `listSshKeys()` | GET | `/ssh_keys` | List SSH keys |
| `updateSshKey()` | PUT | `/ssh_keys/{id}` | Update an SSH key |

### Details

- **`createSshKey()`** — Create an SSH key
  - Creates a new SSH key with the given `name` and `public_key`. Once an SSH key is created, it can be used in other calls such as creating Servers.

- **`deleteSshKey()`** — Delete an SSH key
  - Deletes an SSH key. It cannot be used anymore.

- **`getSshKey()`** — Get a SSH key
  - Returns a specific SSH key object.

- **`listSshKeys()`** — List SSH keys
  - Returns all SSH key objects.

- **`updateSshKey()`** — Update an SSH key
  - Updates an SSH key. You can update an SSH key name and an SSH key labels.

## `volumes` (VolumesClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `attachVolume()` | POST | `/volumes/{id}/actions/attach` | Attach Volume to a Server |
| `changeVolumeProtection()` | POST | `/volumes/{id}/actions/change_protection` | Change Volume Protection |
| `createVolume()` | POST | `/volumes` | Create a Volume |
| `deleteVolume()` | DELETE | `/volumes/{id}` | Delete a Volume |
| `detachVolume()` | POST | `/volumes/{id}/actions/detach` | Detach Volume |
| `getVolume()` | GET | `/volumes/{id}` | Get a Volume |
| `getVolumeAction()` | GET | `/volumes/{id}/actions/{action_id}` | Get an Action for a Volume |
| `getVolumesAction()` | GET | `/volumes/actions/{id}` | Get an Action |
| `listVolumeActions()` | GET | `/volumes/{id}/actions` | List Actions for a Volume |
| `listVolumes()` | GET | `/volumes` | List Volumes |
| `listVolumesActions()` | GET | `/volumes/actions` | List Actions |
| `resizeVolume()` | POST | `/volumes/{id}/actions/resize` | Resize Volume |
| `updateVolume()` | PUT | `/volumes/{id}` | Update a Volume |

### Details

- **`attachVolume()`** — Attach Volume to a Server
  - Attaches a Volume to a Server. Works only if the Server is in the same Location as the Volume.

- **`changeVolumeProtection()`** — Change Volume Protection
  - Changes the protection configuration of a Volume.

- **`createVolume()`** — Create a Volume
  - Creates a new Volume attached to a Server. If you want to create a Volume that is not attached to a Server, you need to provide the `location` key instead of `server`. This can be either the ID or the name of the Location this Volume will be created in. Note that a Volume can be attached to a Server only in the same Location as the Volume itself. Specifying the Server during Volume creation will…

- **`deleteVolume()`** — Delete a Volume
  - Deletes a volume. All Volume data is irreversibly destroyed. The Volume must not be attached to a Server and it must not have delete protection enabled.

- **`detachVolume()`** — Detach Volume
  - Detaches a Volume from the Server it’s attached to. You may attach it to a Server again at a later time.

- **`getVolume()`** — Get a Volume
  - Gets a specific Volume object.

- **`getVolumeAction()`** — Get an Action for a Volume
  - Returns a specific Action for a Volume.

- **`getVolumesAction()`** — Get an Action
  - Returns a specific Action object.

- **`listVolumeActions()`** — List Actions for a Volume
  - Returns all Action objects for a Volume. You can `sort` the results by using the sort URI parameter, and filter them with the `status` parameter.

- **`listVolumes()`** — List Volumes
  - Gets all existing Volumes that you have available.

- **`listVolumesActions()`** — List Actions
  - Returns all Action objects. You can `sort` the results by using the sort URI parameter, and filter them with the `status` and `id` parameter.

- **`resizeVolume()`** — Resize Volume
  - Changes the size of a Volume. Note that downsizing a Volume is not possible.

- **`updateVolume()`** — Update a Volume
  - Updates the Volume properties.

## `zones` (ZonesClient)

| Method | HTTP | Path | Summary |
| --- | --- | --- | --- |
| `addZoneRrsetRecords()` | POST | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}/actions/add_records` | Add Records to an RRSet |
| `changeZonePrimaryNameservers()` | POST | `/zones/{id_or_name}/actions/change_primary_nameservers` | Change a Zone's Primary Nameservers |
| `changeZoneProtection()` | POST | `/zones/{id_or_name}/actions/change_protection` | Change a Zone's Protection |
| `changeZoneRrsetProtection()` | POST | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}/actions/change_protection` | Change an RRSet's Protection |
| `changeZoneRrsetTtl()` | POST | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}/actions/change_ttl` | Change an RRSet's TTL |
| `changeZoneTtl()` | POST | `/zones/{id_or_name}/actions/change_ttl` | Change a Zone's Default TTL |
| `createZone()` | POST | `/zones` | Create a Zone |
| `createZoneRrset()` | POST | `/zones/{id_or_name}/rrsets` | Create an RRSet |
| `deleteZone()` | DELETE | `/zones/{id_or_name}` | Delete a Zone |
| `deleteZoneRrset()` | DELETE | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}` | Delete an RRSet |
| `getZone()` | GET | `/zones/{id_or_name}` | Get a Zone |
| `getZoneAction()` | GET | `/zones/{id_or_name}/actions/{action_id}` | Get an Action for a Zone |
| `getZoneRrset()` | GET | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}` | Get an RRSet |
| `getZoneZonefile()` | GET | `/zones/{id_or_name}/zonefile` | Export a Zone file |
| `getZonesAction()` | GET | `/zones/actions/{id}` | Get an Action |
| `importZoneZonefile()` | POST | `/zones/{id_or_name}/actions/import_zonefile` | Import a Zone file |
| `listZoneActions()` | GET | `/zones/{id_or_name}/actions` | List Actions for a Zone |
| `listZoneRrsets()` | GET | `/zones/{id_or_name}/rrsets` | List RRSets |
| `listZones()` | GET | `/zones` | List Zones |
| `listZonesActions()` | GET | `/zones/actions` | List Actions |
| `removeZoneRrsetRecords()` | POST | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}/actions/remove_records` | Remove Records from an RRSet |
| `setZoneRrsetRecords()` | POST | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}/actions/set_records` | Set Records of an RRSet |
| `updateZone()` | PUT | `/zones/{id_or_name}` | Update a Zone |
| `updateZoneRrset()` | PUT | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}` | Update an RRSet |
| `updateZoneRrsetRecords()` | POST | `/zones/{id_or_name}/rrsets/{rr_name}/{rr_type}/actions/update_records` | Update Records of an RRSet |

### Details

- **`addZoneRrsetRecords()`** — Add Records to an RRSet
  - Adds resource records (RRs) to an RRSet in the Zone. For convenience, the RRSet will be automatically created if it doesn't exist. Otherwise, the new records are appended to the existing RRSet. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this…

- **`changeZonePrimaryNameservers()`** — Change a Zone's Primary Nameservers
  - Overwrites the primary nameservers of a Zone. Only applicable for Zones in secondary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`changeZoneProtection()`** — Change a Zone's Protection
  - Changes the protection configuration of a Zone.

- **`changeZoneRrsetProtection()`** — Change an RRSet's Protection
  - Changes the protection of an RRSet in the Zone. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`changeZoneRrsetTtl()`** — Change an RRSet's TTL
  - Changes the Time To Live (TTL) of an RRSet in the Zone. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`changeZoneTtl()`** — Change a Zone's Default TTL
  - Changes the default Time To Live (TTL) of a Zone. This TTL is used for RRSets that do not explicitly define a TTL. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`createZone()`** — Create a Zone
  - Creates a Zone. A default `SOA` and three `NS` resource records with the assigned Hetzner nameservers are created automatically.

- **`createZoneRrset()`** — Create an RRSet
  - Create an RRSet in the Zone. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`deleteZone()`** — Delete a Zone
  - Deletes a Zone.

- **`deleteZoneRrset()`** — Delete an RRSet
  - Deletes an RRSet from the Zone. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`getZone()`** — Get a Zone
  - Returns a single Zone.

- **`getZoneAction()`** — Get an Action for a Zone
  - Returns a specific Action for a Zone.

- **`getZoneRrset()`** — Get an RRSet
  - Returns a single RRSet from the Zone. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`getZoneZonefile()`** — Export a Zone file
  - Returns a generated Zone file in BIND (RFC 1034/1035) format. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`getZonesAction()`** — Get an Action
  - Returns a specific Action.

- **`importZoneZonefile()`** — Import a Zone file
  - Imports a zone file, replacing all resource record sets (RRSets). The import will fail if existing RRSet are `change` protected. See Zone file import for more details. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`listZoneActions()`** — List Actions for a Zone
  - Returns all Actions for a Zone. Use the provided URI parameters to modify the result.

- **`listZoneRrsets()`** — List RRSets
  - Returns all RRSets in the Zone. Use the provided URI parameters to modify the result. The maximum value for `per_page` on this endpoint is `100` instead of `50`. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`listZones()`** — List Zones
  - Returns all Zones. Use the provided URI parameters to modify the result.

- **`listZonesActions()`** — List Actions
  - Returns all Zone Actions. Use the provided URI parameters to modify the result.

- **`removeZoneRrsetRecords()`** — Remove Records from an RRSet
  - Removes resource records (RRs) from an existing RRSet in the Zone. For convenience, the RRSet will be automatically deleted if it doesn't contain any RRs afterwards. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`setZoneRrsetRecords()`** — Set Records of an RRSet
  - Overwrites the resource records (RRs) of an existing RRSet in the Zone. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`updateZone()`** — Update a Zone
  - Updates a Zone. To modify resource record sets (RRSets), use the RRSet Actions endpoints.

- **`updateZoneRrset()`** — Update an RRSet
  - Updates an RRSet in the Zone. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

- **`updateZoneRrsetRecords()`** — Update Records of an RRSet
  - Updates resource records' (RRs) comments of an existing RRSet in the Zone. Only applicable for Zones in primary mode. #### Operation specific errors \| Status \| Code \| Description \| \| --- \| --- \| --- \| \| `422` \| `incorrect_zone_mode` \| This operation is not supported for this Zone's `mode`. \|

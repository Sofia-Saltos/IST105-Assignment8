import json
from ipaddress import IPv4Network, IPv6Network

# Predefined subnets
ipv4_subnet = IPv4Network("192.168.1.0/24")
ipv6_subnet = IPv6Network("2001:db8::/64")


lease_db = {}

def validate_mac(mac):
    # Here, I did a simple MAC address validation
    return len(mac.split(":")) == 6

def generate_ipv6(mac):
    mac_bytes = mac.replace(":", "")
    eui64 = mac_bytes[:6] + "fffe" + mac_bytes[6:]
    ipv6 = f"{ipv6_subnet.network_address}::{eui64[:4]}:{eui64[4:8]}:{eui64[8:]}"
    return ipv6

def assign_ip(mac, dhcp_version):
    if mac in lease_db:
        return lease_db[mac]
    
    if dhcp_version == "DHCPv4":
        for ip in ipv4_subnet.hosts():
            if ip not in lease_db.values():
                lease_db[mac] = {"ip": str(ip), "lease_time": 3600}
                return lease_db[mac]
    elif dhcp_version == "DHCPv6":
        ipv6 = generate_ipv6(mac)
        lease_db[mac] = {"ip": ipv6, "lease_time": 3600}
        return lease_db[mac]
    return None

def handle_request(mac, dhcp_version):
    if not validate_mac(mac):
        return {"error": "Invalid MAC address format"}
    
    ip_info = assign_ip(mac, dhcp_version)
    if not ip_info:
        return {"error": "No available IPs in the subnet"}
    return {"mac_address": mac, "assigned_ip": ip_info["ip"], "lease_time": f"{ip_info['lease_time']} seconds"}

# This code part is for simulting a user input for testing
if __name__ == "__main__":
    mac_address = "00:1A:2B:3C:4D:5E"
    dhcp_version = "DHCPv6"
    response = handle_request(mac_address, dhcp_version)
    print(json.dumps(response, indent=2))

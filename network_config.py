import sys
import json
import re
import ipaddress

# Simulated lease database
leases = {}

def validate_mac(mac):
    """Validate MAC address format."""
    return re.match(r"^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$", mac)

def generate_ipv6(mac):
    """Generate an IPv6 address using EUI-64 format."""
    parts = mac.split(':')
    parts.insert(3, 'ff')
    parts.insert(4, 'fe')
    parts[0] = "{:02x}".format(int(parts[0], 16) ^ 0x02)
    ipv6_suffix = ':'.join(parts)
    return f"2001:db8::{ipv6_suffix}"

def assign_ip(mac, dhcp_version):
    """Assign an IP address based on the DHCP version."""
    if mac in leases:
        return leases[mac]

    if dhcp_version == "DHCPv4":
        ip = f"192.168.1.{len(leases) + 10}"
    elif dhcp_version == "DHCPv6":
        ip = generate_ipv6(mac)
    else:
        return None

    leases[mac] = {
        'mac_address': mac,
        f'assigned_ip{dhcp_version[-1]}': ip,
        'lease_time': 3600  
    }
    return leases[mac]

def main():
    mac = sys.argv[1]
    dhcp_version = sys.argv[2]

    if not validate_mac(mac):
        print(json.dumps({'error': 'Invalid MAC address format'}))
        return

    result = assign_ip(mac, dhcp_version)
    if result:
        print(json.dumps(result))
    else:
        print(json.dumps({'error': 'Invalid DHCP version'}))

if __name__ == "__main__":
    main()
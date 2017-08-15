#!/bin/bash

ip=$(getent hosts main | awk '{ print $1 }')
echo "$ip $1" >> /etc/hosts


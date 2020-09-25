#!/usr/bin/env python
#--------------------------------------
#
# Script to switch ON or OFF the Energenie sockets through PiMote 
# add-on board for the Raspberry Pi. This is using Energenie Python
# module. On Raspberry Pi, install the energenie module in pip (Python 3)
#
# sudo apt-get install python3-pip
# sudo pip-3.2 install energenie
#
#--------------------------------------
# Import modules

import energenie as e
import time
import sys

# Get command line arguments
socketID=int(sys.argv[1])
action=sys.argv[2]

if(socketID > 4 or socketID < 1 or (action != 'on' and action != 'off')):
  exit("Invalid arguments")

if(sys.argv[2] == 'on'):
  e.switch_on(socketID)
elif(sys.argv[2] == 'off'):
  e.switch_off(socketID)


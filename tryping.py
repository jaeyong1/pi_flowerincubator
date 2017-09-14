#!/usr/bin/env python

import subprocess
import os
import threading, requests, time


def check_ping():
    hostname = "192.168.0.1"
    response = os.system("ping -c 1 " + hostname)
    # and then check the response...
    if response == 0:
        pingstatus = "Network Active"
    else:
        pingstatus = "Network Error"

    return pingstatus
    
def start_ping_loop():
	while True:
		pingstatus = check_ping()
		#print(pingstatus)  ## warning! too much print
		time.sleep(0.5)
		
def main():
	t = threading.Thread(target=start_ping_loop, args=())
	t.daemon = True
	t.start()

if __name__ == '__main__':
	main()
	

		
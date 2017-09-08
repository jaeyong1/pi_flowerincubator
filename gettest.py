#!/usr/bin/env python
import threading
import time
import feedparser
import RPi.GPIO as GPIO
import urllib2 
import datetime, time
from datetime import timedelta, datetime
from picftp import takepicture_ftpuplod
from tendo import singleton
from c_incubator import *
from getht import *


def main():
	print("****************************************************")
	
	try:
		d = feedparser.parse('http://jaeyong1.cafe24.com/garden/get_remote_xml.php1')
		hasdata = d.feed.hasdata
		print("hasdata:" + hasdata)
	except:
		print("is error")
	
if __name__ == '__main__':
	main()
	
		
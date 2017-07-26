import threading
import time
import feedparser
import RPi.GPIO as GPIO
import urllib2 

def getcommand():
	#get command from db by xml
	d = feedparser.parse('http://jaeyong1.cafe24.com/garden/get_remote_xml.php')
	hasdata = d.feed.hasdata
	print("hasdata:" + hasdata)
	
	#parse xml
	if int(hasdata) != 0:
		print (d.feed.rid)
		print (d.feed.timestamp)
		print (d.feed.command)
		print (d.feed.state)
		
		#set ok to db
		rid = d.feed.rid
		urllib2.urlopen("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid).read() #python 2
		#print ("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid)
		#	import urllib.request #python 3
		#	urllib.request.urlopen("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid).read()
 
def GPIOInit():
	GPIO.setmode(GPIO.BCM)
	GPIO.setup(14, GPIO.OUT)
	GPIO.setup(15, GPIO.OUT)	
	
def LightOn():
	GPIO.output(14, True)

def LightOff():
	GPIO.output(14, False)

def FanOn():
	GPIO.output(15, True)
	
def FanOff():
	GPIO.output(15, False)

def _internal_GPIOcontrolTest():
	GPIO.setmode(GPIO.BCM)
	GPIO.setup(15, GPIO.OUT)
	GPIO.output(15, False)
	#GPIO.output(14, True)
	GPIO.output(15, True)	
	GPIO.output(15, False)
	GPIO.cleanup()



hasda
def main():
	print("****************************************************")
	print("PI FLOWER INCUBATOR")
	print("")	
	print("https://github.com/jaeyong1/pi_flowerincubator/wiki")	
	print("****************************************************")
	print("  1) get command from web site")
	print("  2) wait 1 min")
	print("  3) get command again")
	print("")
	
		
	
	for i in range(0,55):
		print(i)
		time.sleep(1) #1 sec
		
if __name__ == '__main__':
	main()
	
		
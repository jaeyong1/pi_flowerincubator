import feedparser

#get xml
d = feedparser.parse('http://jaeyong1.cafe24.com/garden/get_remote_xml.php')

hasdata = d.feed.hasdata
print("hasdata:" + hasdata)
#parse
if int(hasdata) != 0:
	print (d.feed.rid)
	print (d.feed.timestamp)
	print (d.feed.command)
	print (d.feed.state)
	
	rid = d.feed.rid
	print ("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid)
	#set ok
#	import urllib.request #python 3
#	urllib.request.urlopen("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid).read()
  	import urllib2 
	urllib2.urlopen("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid).read() #python 2

else : #if int(hasdata) != 0:
  print ("no more data")


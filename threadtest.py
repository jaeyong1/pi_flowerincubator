import threading
import threading, requests, time

def sum(low, high):
    total = 0;
    for i in range(low,high):
      total += i
    print("Subthread", total)
    
t = threading.Thread(target=sum, args=(1, 100000))
t.start()

def whileloopthread():
	time.sleep(1)
	print("1 sec")

t = threading.Thread(target=whileloopthread)
t.start()

print("Main Thread")

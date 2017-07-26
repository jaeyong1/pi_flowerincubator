# pi_flowerincubator
raspberry pi for flower incubator


[install samba]
pi@raspberrypi:~ $ sudo apt-get install samba samba-common-bin

[add pi user]
pi@raspberrypi:~ $ sudo smbpasswd -a pi

[add config for pi user]
pi@raspberrypi:~ $ sudo vi /etc/samba/smb.conf

[pi]
comment = pi folder
path=/home/pi
valid user = pi
writable = yes
browseable = yes

pi@raspberrypi:~ $ service smbd restart

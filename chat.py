from socket import *
import struct
import json
import re
import hashlib
import base64
import _thread
s=socket(AF_INET,SOCK_STREAM)
hos=input("Enter Host/IP [optional]:");
try:
   s.bind((hos,8888))
except:
   s.bind(("localhost",8888))
s.listen(10)
print("Server Started")
y="258EAFA5-E914-47DA-95CA-C5AB0DC85B11"
clients=[]
users={}
dat=1
def clo(p,q,r):
    p.close()
    del users[p]
    clients.remove(p)
    print(q+":"+str(r)+" Offline")
          
run=1;
def rec(p,q,r):
    while run:
     #for x in clients:
       x=p.recv(1024)
       if x==b'':
             clo(p,q,r);
             break;
       if not x:
             clo(p,q,r)
             break;
       else:
        try:
         m=x[1]-128
         i=0
         j=6
         k=0
         msg=''
         while i!=m:
           msg=msg+chr(x[j]^x[2+k])
           i=i+1;
           j=j+1;
           k=(k+1)%4;
         print(msg)
         sen(p,msg,q,r)
        except:
          a=""
def sen(p,msg,q,r):
       for k in clients:
         if k!=p:
           raw=msg
           byt=[]
           byt.append(struct.pack('B', 129))
           byt.append(struct.pack('B', len(raw)))
           for i in range(len(raw)):
               byt.append(struct.pack('B', ord(raw[i])))
           try:
             k.send(b''.join(byt))
           except:
             print("Error Sending.... ")
             clo(p,q,r)
def use(p,a):
        x=p.recv(1024)
        try:
         m=x[1]-128
         i=0
         j=6
         k=0
         msg=''
         while i!=m:
           msg=msg+chr(x[j]^x[2+k])
           i=i+1;
           j=j+1;
           k=(k+1)%4;
         print(msg)
         users[p]=msg;
         for i in users:
            print(users[i])
        except:
         a=""
while True:
   p,a=s.accept()
   if(p not in clients):
     print(a[0]+":"+str(a[1])+" Online")
     clients.insert(len(clients),p)
     t=p.recv(1024).decode()
     #print(t);
     m=re.search("Key:(.*)==",t);
     n=m.group()
     n=n[5:]
     x=n+y
     x=x.encode()
     x=base64.b64encode(hashlib.sha1(x).digest())
     h=('HTTP/1.1 101 Switching Protocols\r\n'
     'Upgrade: WebSocket\r\n'
     'Connection: Upgrade\r\n'
     'Sec-WebSocket-Accept: '+x.decode()+'\r\n\r\n')
     try:
        p.send(h.encode())
     except:
        print("Error")
     use(p,a);
     _thread.start_new_thread(rec,(p,a[0],a[1]))

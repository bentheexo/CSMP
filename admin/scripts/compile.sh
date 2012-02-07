#! /bin/sh
#SVN Update Script

su csmp
cd /opt/csmp/admin/server
if [ `uname -i` = i386 ]
then ./configure && make clean && make sql
else ./configure --enable-64bit && make clean && make sql
fi

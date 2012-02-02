#! /bin/sh
#SVN Update Script


if `uname -i` == i386
then ./configure && make clean && make sql
else ./configure --enable-64bit && make clean && make sql
fi

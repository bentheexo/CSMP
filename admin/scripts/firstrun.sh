#! /bin/sh
# First run script for Debian, Ubuntu, CentOS, or Fedora


useradd -D -b /opt -d csmp/admin/server -g root csmp

su csmp

if [ -f /etc/redhat-release ] #CentOS for sure, maybe Fedora
then
	if `uname -i` == i386
	then
	wget http://packages.sw.be/rpmforge-release/rpmforge-release-0.5.2-2.el5.rf.i386.rpm
	rpm --import http://apt.sw.be/RPM-GPG-KEY.dag.txt
	rpm -Uhv rpmforge-release*
	yum update
	else
	wget http://packages.sw.be/rpmforge-release/rpmforge-release-0.5.2-2.el5.rf.x86_64.rpm
	rpm --import http://apt.sw.be/RPM-GPG-KEY.dag.txt
	rpm -Uhv rpmforge-release*
	yum update
	fi
yum update -y && yum install subversion gcc make automake cmake git mysql-devel pcre-devel zlib-devel
echo "System Pre-requisites have all been met"
elif [ -f /etc/issue ] #Possibly Ubuntu
then
apt-get update && apt-get install libmysqlclient16-dev libpcre3-dev zlib1g-dev subversion gcc-4.5 make cmake automake git-all
echo "System Pre-requisites have all been met"
elif [ -f /etc/debian_version
then
apt-get update && apt-get install libmysqlclient16-dev libpcre3-dev zlib1g-dev subversion gcc-4.5 make cmake automake git-all
echo "System Pre-requisites have all been met"
fi
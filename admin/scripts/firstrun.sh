#! /bin/sh
# First run script for Debian, Ubuntu, CentOS, or Fedora

if

if [ -f /etc/redhat-release ] #CentOS for sure, maybe Fedora
then
yum update -y && yum install subversion gcc make automake cmake git mysql-devel pcre-devel zlib-devel
echo "System Pre-requisites have all been met"
elif [ -f /etc/issue ] #Possibly Ubuntu

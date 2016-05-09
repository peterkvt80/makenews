#!/bin/sh

cd /opt/bitnami/apps/makenews
php newsreader.php
./render.sh
php tti7bit.php
#mv BBC100.ttix BBC100.ttix.BAK
cp -f *.ttix /opt/bitnami/apps/muttlee/BBCNEWS

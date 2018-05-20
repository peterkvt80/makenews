# makenews
PHP scripts to make TTI teletext pages from the BBC News website

If you do not already have the php interpreter installed type

<b>sudo apt-get update

If you've got a version of Raspbian<b> older </b>than Stretch, type

<b>sudo apt-get install php5-common php5-cli

If you've got Raspbian Stretch or above, do

<b>sudo apt-get install php7.0-common php7.0-cli php7.0-xml

Place all the files in a handy folder. In my case I'm using /home/pi/makenews.
To make it easier to update files I'll use git.

<b>sudo apt-get install git

<b>git clone https://github.com/peterkvt80/makenews/ ~/makenews/
  
# make
The top level is make.sh. You'll need to edit make.sh to suit your file organisation.

make.sh works like this:
newsreader.php downloads html from BBC News and saves them as html files.
render.sh runs newsindex for page 100, newsindex for page 102 and newsformat.php for pages 104 onwards. It creates a tti file for each teletext page.
tti7bit.php converts the tti (8 bit) to ttix (7 bit). Javascript has a big problem with ASCII so we convert the files to Prestel escapes.
Finally there is a copy command to move the files where you want.

#How to CRON this
To create a schedule type

<b>sudo crontab -e

Add your schedules to the end

  0  8 * * * /home/pi/makenews/make.sh

  55 20 * * * /home/pi/makenews/make.sh
  
In this example it means run the page making script at 0800 and 2055.

# Using with Muttlee
Muttlee organises the services simply as named subdirectories. The last command of make.sh copies the files into this folder:
This means copy all the ttix file to the BBCNEWS folder.

<b>cp -f *.ttix /opt/bitnami/muttlee/BBCNEWS

# Teefax
If adding news to Teefax, you need to checkout the Teefax pages 
# Get the current Teefax pages

<b>svn checkout http://localhost/svn/teletext /home/pi/teletext

Add these lines to make.sh to copy the files to the repository

    #!/bin/sh

    cd /home/pi/makenews
    php newsreader.php
    ./render.sh
    php tti7bit.php
    #mv BBC100.ttix BBC100.ttix.BAK

    rm BBC100.ttix
    rm BBC102.ttix
    cd /home/pi/teletext
    svn update
    cp -f /home/pi/makenews/*.ttix .
    svn commit --non-interactive --username Heine --password Kin --message "Auto generated BBC News"


Run this script to create the pages but it won't commit them just yet.
The first time you need to add the BBC news pages to the repository

<b>cd /home/pi/teletext
<b>svn add BBC*.*
    
The next time you run the script it will do the commit.
    


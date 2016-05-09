# makenews
PHP scripts to make TTI teletext pages from the BBC News website

If you do not already have the php interpreter installed type
sudo apt-get install php5-common php5-cli

Place all the files in a handy folder. In my case I'm using /opt/bitnami/apps/makenews
The top level is make.sh. You'll need to edit make.sh to suit your file organisation.

make.sh works like this:
newsreader.php downloads html from BBC News and saves them as html files.
render.sh runs newsindex for page 100, newsindex for page 102 and newsformat.php for pages 104 onwards. It creates a tti file for each teletext page.
tti7bit.php converts the tti (8 bit) to ttix (7 bit). Javascript has a big problem with ASCII so we convert the files to Prestel escapes.
Finally there is a copy command to move the files where you want.

#How to CRON this
To create a schedule type
crontab -e
Add your schedules to the end

  0  8 * * * /opt/bitnami/apps/makenews/make.sh

  55 20 * * * /opt/bitnami/apps/makenews/make.sh
  
In this example it means run the page making script at 0800 and 2055.

# Using with Muttlee
Muttlee organises the services simply as named subdirectories. The last command of make.sh copies the files into this folder:
This means copy all the ttix file to the BBCNEWS folder.
cp -f *.ttix /opt/bitnami/muttlee/BBCNEWS


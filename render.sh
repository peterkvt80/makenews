#!/bin/sh

#render.bat
php weatherreader.php
php newsindex.php > BBC100.tti
php newsindex2.php > BBC102.tti
php newsformat.php page0.html 10400 > BBC104.tti
php newsformat.php page1.html 10500 > BBC105.tti
php newsformat.php page2.html 10600 > BBC106.tti
php newsformat.php page3.html 10700 > BBC107.tti
php newsformat.php page4.html 10800 > BBC108.tti
php newsformat.php page5.html 10900 > BBC109.tti
php newsformat.php page6.html 11000 > BBC110.tti
php newsformat.php page7.html 11100 > BBC111.tti
php newsformat.php page8.html 11200 > BBC112.tti
php newsformat.php page9.html 11300 > BBC113.tti
php newsformat.php page10.html 11400 > BBC114.tti
php newsformat.php page11.html 11500 > BBC115.tti
php newsformat.php page12.html 11600 > BBC116.tti
php newsformat.php page13.html 11700 > BBC117.tti
php newsformat.php page14.html 11800 > BBC118.tti
php newsformat.php page15.html 11900 > BBC119.tti
php newsformat.php page16.html 12000 > BBC120.tti
php newsformat.php page17.html 12100 > BBC121.tti
php newsformat.php page18.html 12200 > BBC122.tti
php newsformat.php page19.html 12300 > BBC123.tti
php newsformat.php page20.html 12400 > BBC124.tti
php weathermap.php > MENU401.tti

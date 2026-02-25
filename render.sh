#!/bin/sh

#render.bat
php tvlistingsreader.php
php listings.php BBC1 0 > MENU601.tti
php listings.php BBC2 0 > MENU602.tti
php listings.php UTV 0 > MENU603.tti
php listings.php C4 0 > MENU604.tti
php listings.php C5 0 > MENU605.tti
php listings.php BBC1 3 > MENU631.tti
php listings.php BBC2 3 > MENU632.tti
php listings.php UTV 3 > MENU633.tti
php listings.php C4 3 > MENU634.tti
php listings.php C5 3 > MENU635.tti
php weatherreader.php
php newsreader.php
php newsindex.php > BBC100.tti
php newsindex1.php > BBC101.tti
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
php weatherformat.php > MENU402.tti
php weatherformat403.php > MENU403.tti
php sportreader.php
php footindx.php > MENU302.tti
php footformat.php foot0.html 30300 > MENU303.tti
php footformat.php foot1.html 30400 > MENU304.tti
php footformat.php foot2.html 30500 > MENU305.tti
php footformat.php foot3.html 30600 > MENU306.tti
php footformat.php foot4.html 30700 > MENU307.tti
php footformat.php foot5.html 30800 > MENU308.tti
php footformat.php foot6.html 30900 > MENU309.tti
php footformat.php foot7.html 31000 > MENU310.tti
php footformat.php foot8.html 31100 > MENU311.tti
php footformat.php foot9.html 31200 > MENU312.tti
php footformat.php foot10.html 31300 > MENU313.tti
php footformat.php foot11.html 31400 > MENU314.tti
php footformat.php foot12.html 31500 > MENU315.tti

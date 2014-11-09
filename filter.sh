#!/bin/bash

file=$1
filename=.test.tmp
grep -v \'\'\' $file | grep -v filelist=\'\' > $filename 

sed s/=\'\'/=\'\\\\\'/g $filename | sed s/\'\'\ /\\\\''\'\'\ /g | sed "s/$/;/g" | sed "s/\([a-z]\)'\(s\)/\1\\\'\2/g" | sed "s/\([A-Z]\)'\(s\)/\1\\\'\2/g" | sed "s/\([a-z]\)'\(l\)/\1\\\'\2/g" | sed "s/\([a-z]\)'\(r\)/\1\\\'\2/g" | sed "s/\(n\)'\(t\)/\1\\\'\2/g" | sed "s/\(o\)'\(c\)/\1\\\'\2/g" | sed "s/\(e\)'\(v\)/\1\\\'\2/g" | sed "s/\(I\)'\(v\)/\1\\\'\2/g" | sed "s/\(u\)'\(v\)/\1\\\'\2/g" | sed "s/\([a-z]\)'\([A-Z]\)/\1\\\'\2/g" | sed "s/\(O\)'\([a-z]\)/\1\\\'\2/g" | sed "s/\(O\)'\([A-Z]\)/\1\\\'\2/g" | sed "s/\(I\)'\(m\)/\1\\\'\2/g" | sed "s/\([A-Z]\)'\(l\)/\1\\\'\2/g" | sed "s/\([a-z]\)'\([a-z]\)/\1\\\'\2/g" | sed "s/\([a-z]\)\'-\([a-z]\)/\1\\\'-\2/g" | sed "s/\([A-Z]\)'\([A-Z]\)/\1\\\'\2/g" | sed "s/\([A-Z]\)'\([a-z]\)/\1\\\'\2/g" | sed "s/'\([a-z]\)'\([a-z]\)/\\'\1\\\'\2/g" | sed "s/-'n\\\'/-\\\'n\\\'/g" | sed "s/-'\([a-z]\)/-\\\'\1/g" > test.sql
/applications/MAMP/library/bin/mysql -u root  parligram < test.sql
#mv testfile.sql $filename

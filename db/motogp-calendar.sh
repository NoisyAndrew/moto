#!/bin/sh

echo `basename ${1} .json`.sql

cat ${1} | jq -r '
def format_date(date): 
  date[0:4] + "-" + date[4:6] + "-" + date[6:8] + " " + date[9:11] + ":" + date[11:13] + ":" + date[13:15];

"insert into events (name, date) values\n" + 
([.VCALENDAR[0].VEVENT[] | "('\''\(.SUMMARY)'\'', '\''\(format_date(.DTSTART))'\'')"] | join(",\n")) + 
"\non conflict do nothing;"
' > `basename ${1} .json`.sql
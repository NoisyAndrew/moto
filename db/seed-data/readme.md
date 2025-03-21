# Generating Seed Data

## Events

These awk scripts were developed against the 2025 season official web sources. Future years may change the formats requiring a rewrite of the extraction scripts.

* Download the [event calendar (motogp-calendar-2025.ics)](https://resources.motogp.com/files/ics/motogp-calendar-2025.ics) from the official site and save to this directory.
* Run the awk script  to create the sql insert script.

```sh
 ./motogp-calendar.awk motogp-calendar-2025.ics > motogp-calendar-2025.sql
 ```

## Riders

* Download the source code of the [riders and teams web page](https://www.motogp.com/en/riders/motogp), HTML only,  and save it to this directory.
* Run the awk script to create the sql insert script.

```sh
./motogp-riders.awk motogp-riders-2025.html > motogp-riders-2025.sql
```
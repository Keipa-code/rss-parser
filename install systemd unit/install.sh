#!/bin/bash
chown root:root rss-fetcher.service
cp ./rss-fetcher.service /etc/systemd/system/rss-fetcher.service
#!/bin/bash

cat ~/openproject/config/database.yml | grep password
psql -U {{pac}}_{{user}} {{pac}}_{{user}}
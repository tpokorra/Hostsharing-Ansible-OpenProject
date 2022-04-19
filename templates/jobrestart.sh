#!/bin/bash

source ~/.profile
cd ~/openproject
RAILS_ENV="production"  ./bin/delayed_job restart

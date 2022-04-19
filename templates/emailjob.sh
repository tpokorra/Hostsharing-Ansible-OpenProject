#!/bin/bash

source ~/.profile
cd ~/openproject
RAILS_ENV="production" ./bin/rake jobs:workoff

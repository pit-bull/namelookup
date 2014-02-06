#!/usr/bin/python

import sys
import subprocess
import json
import re
import os
import time

COMMAND = '/home/namecoin/namecoin/src/namecoind'
PARAM = 'name_show'

MSG_TEMPLATE = '<b>Name:</b> {name}<br><b>Email:</b> {email}<br><b>Owner:</b> {owner}<br><b>Expires in:</b> {expires} blocks<br><br><b>Associated data:</b><br>{value}'

def main(user_param):
    user_param = user_param.strip()

    if not os.path.exists(COMMAND):
        print('No such command "{cmd}" in the current path.'.format(cmd=COMMAND))
        sys.exit(1)

    env = os.environ.copy()
    env['HOME'] = '/home/namecoin'
    p1 = subprocess.Popen([COMMAND, PARAM, user_param],
                          stdout=subprocess.PIPE,
                          stderr=subprocess.PIPE,
                          stdin=subprocess.PIPE,
                          env=env,
                          close_fds=True)
    p1.wait()
    output, err = p1.communicate()

    try:
        json_data = json.loads(output)
    except Exception, e:
        print('No results for {param}'.format(param=user_param))
        sys.exit(0)

    name = json_data['name']
    email2 = re.findall(r'[\w\.-]+@[\w\.-]+', json_data['value'])
    owner = json_data['address']
    expires = json_data['expires_in']
    value = json_data['value']

#    email.split("'")[1]

    print(MSG_TEMPLATE.format(name=name, email=str(email2), owner=owner, expires=expires, value=value))

if __name__ == '__main__':
    try:
        main(sys.argv[1])
    except IndexError:
        print('No parameter was provided')
        sys.exit(1)

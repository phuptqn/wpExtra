# import fabric third-party
from fabric.api import local, run, env
from fabric.colors import green, red
from fabric.contrib.files import exists

SERVERS = dict(
    staging = dict(
        host = 'ip_here',
        user = 'user_here',
        keyFile = './id_rsa',
        port = 'port_here',
        src = '../',
        srcRoot = '../../../../',
        dest = '/home/web',
        destRoot = '/home',
        excludeFile = '\'../rsync_exclude.txt\'',
        excludeFileRoot = '\'../../../../rsync_exclude.txt\''
    ),
    prod = dict(
        host = 'ip_here',
        user = 'user_here',
        keyFile = './id_rsa',
        port = 'port_here',
        src = '../',
        dest = '/home/web',
        excludeFile = '\'../rsync_exclude.txt\''
    )
)


def prepare_env(server_name='staging'):
    env.host_string = SERVERS[server_name]['host']
    env.user = SERVERS[server_name]['user']
    env.key_filename = SERVERS[server_name]['keyFile']
    env.port = SERVERS[server_name]['port']
    env['name'] = server_name


def connect_server(server_name='staging'):
    """
    Script to connect to server
    """
    prepare_env(server_name)

    if exists('/etc'):
        print(green('Connected to %s server.....' % server_name))
        return True
    else:
        print(red('Can\'t connect to %s server. Please double check your list of IPs in hosts' % server_name))
        return False


def deploy(server_name='staging'):
    """
    Script to deploy special server
    """
    print(green('Start deploy %s.....' % server_name))

    sync_code_to_server(server_name)


def sync_code_to_server(server_name='staging'):
    """
    Script to sync built code from local to server
    """
    if connect_server(server_name):
        if not exists(SERVERS[server_name]['dest']):
            run('mkdir -p %s' % SERVERS[server_name]['dest'])

    print(green('Start sync code to %s server.....' % server_name))
    local('echo Build app...')

    local('gulp build')

    local('rsync -avHPe ssh %s -e "ssh -i %s -p %s" --rsync-path="rsync" %s@%s:%s --exclude-from %s' % (SERVERS[server_name]['src'], SERVERS[server_name]['keyFile'], SERVERS[server_name]['port'], SERVERS[server_name]['user'], SERVERS[server_name]['host'], SERVERS[server_name]['dest'], SERVERS[server_name]['excludeFile']))

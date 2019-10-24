# import fabric third-party
from fabric.api import local, run, env
from fabric.colors import green, red
from fabric.contrib.files import exists

SERVERS = dict(
    stag = dict(
        host = '139.99.121.6',
        user = 'gpj',
        keyFile = './key_stag',
        port = '60022',
        gitBranch = 'develop',
        src = '../',
        srcRoot = '../../../../',
        dest = '/home/gpj/web/gpj.bjdev.net/public_html/wp-content/themes/gpj',
        destRoot = '/home/gpj/web/gpj.bjdev.net/public_html',
        excludeFile = '\'../rsync_exclude.txt\'',
        excludeFileRoot = '\'../../../../rsync_exclude.txt\''
    )
)


def prepare_env(server_name='stag'):
    env.host_string = SERVERS[server_name]['host']
    env.user = SERVERS[server_name]['user']
    env.key_filename = SERVERS[server_name]['keyFile']
    env.port = SERVERS[server_name]['port']
    env['name'] = server_name


def connect_server(server_name='stag'):
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


def deploy(server_name='stag'):
    """
    Script to deploy special server
    """
    print(green('Start Deploy THEME %s.....' % server_name))

    sync_code_to_server(server_name, 'theme')

def deploy_root(server_name='stag'):
    """
    Script to deploy special server
    """
    print(green('Start Deploy ROOT %s.....' % server_name))

    sync_code_to_server(server_name, 'root')


def sync_code_to_server(server_name='stag', folder='theme'):
    """
    Script to sync built code from local to server
    """
    if connect_server(server_name):
        if not exists(SERVERS[server_name]['dest']):
            run('mkdir -p %s' % SERVERS[server_name]['dest'])

    print(green('[GIT] Switching to branch %s...' % SERVERS[server_name]['gitBranch']))
    local('git checkout %s' % SERVERS[server_name]['gitBranch'])

    print(green('[GIT] Pull code from branch %s...' % SERVERS[server_name]['gitBranch']))
    local('git pull')

    print(green('Build app...'))
    local('gulp build')

    if folder == 'theme':
        print(green('Start sync THEME code to %s server.....' % server_name))
        local('rsync -avHPe ssh %s -e "ssh -i %s -p %s" --rsync-path="rsync" %s@%s:%s --exclude-from %s' % (SERVERS[server_name]['src'], SERVERS[server_name]['keyFile'], SERVERS[server_name]['port'], SERVERS[server_name]['user'], SERVERS[server_name]['host'], SERVERS[server_name]['dest'], SERVERS[server_name]['excludeFile']))
    elif folder == 'root':
        print(green('Start sync ROOT code to %s server.....' % server_name))
        local('rsync -avHPe ssh %s -e "ssh -i %s -p %s" --rsync-path="rsync" %s@%s:%s --exclude-from %s' % (SERVERS[server_name]['srcRoot'], SERVERS[server_name]['keyFile'], SERVERS[server_name]['port'], SERVERS[server_name]['user'], SERVERS[server_name]['host'], SERVERS[server_name]['destRoot'], SERVERS[server_name]['excludeFileRoot']))
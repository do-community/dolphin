# Fetching Info

You can fetch information such as ssh keys currently added to your account, available droplet sizes and images. 
This information is relevant for creating new droplets and for setting the default values for new droplets in your `config.php` file. 

### Fetching Available Regions

To get a list of all available regions you can use when creating a new Droplet, use:

```
./dolphin fetch regions
```

```
NAME             SLUG      AVAILABLE
New York 1       nyc1      1
San Francisco 1  sfo1      1
New York 2       nyc2      1
Amsterdam 2      ams2      1
Singapore 1      sgp1      1
London 1         lon1      1
New York 3       nyc3      1
Amsterdam 3      ams3      1
Frankfurt 1      fra1      1
Toronto 1        tor1      1
San Francisco 2  sfo2      1
Bangalore 1      blr1      1
```

### Fetching Available Sizes

To get a list of all available sizes you can use when creating a new Droplet, use:

```
./dolphin fetch sizes
```

```
SLUG         MEMORY    VCPUS     DISK      TRANSFER  PRICE/MONTH
512mb        512MB     1         20GB      1TB       $5
s-1vcpu-1gb  1024MB    1         25GB      1TB       $5
1gb          1024MB    1         30GB      2TB       $10
s-1vcpu-2gb  2048MB    1         50GB      2TB       $10
s-1vcpu-3gb  3072MB    1         60GB      3TB       $15
s-2vcpu-2gb  2048MB    2         60GB      3TB       $15
s-3vcpu-1gb  1024MB    3         60GB      3TB       $15
2gb          2048MB    2         40GB      3TB       $20
s-2vcpu-4gb  4096MB    2         80GB      4TB       $20
4gb          4096MB    2         60GB      4TB       $40
c-2          4096MB    2         25GB      4TB       $40
m-1vcpu-8gb  8192MB    1         40GB      5TB       $40
s-4vcpu-8gb  8192MB    4         160GB     5TB       $40
g-2vcpu-8gb  8192MB    2         25GB      4TB       $60
gd-2vcpu-8gb 8192MB    2         50GB      4TB       $65
m-16gb       16384MB   2         60GB      5TB       $75
8gb          8192MB    4         80GB      5TB       $80
c-4          8192MB    4         50GB      5TB       $80
s-6vcpu-16gb 16384MB   6         320GB     6TB       $80
g-4vcpu-16gb 16384MB   4         50GB      5TB       $120
```

### Fetching Available SSH Keys

To get a list of all registered SSH Keys you can use when creating a new Droplet, use:

```
./dolphin fetch keys
```

```
ID        NAME      FINGERPRINT
23937789  heidislab e7:51:a3:7e:e1:11:1b:d1:69:8e:98:3d:45:5f:7f:14
```

### Fetching Available Droplet Images

```shell
./dolphin fetch images
```

```
ID        NAME               DIST           SLUG                  TYPE      MIN_DISK_SIZE  VISIBILITY
31354013  6.9 x32            CentOS         centos-6-x32          snapshot  20GB           public    
33948356  28 x64             Fedora         fedora-28-x64         snapshot  20GB           public    
34114584  28 x64 Atomic      Fedora Atomic  fedora-28-x64-atomic  snapshot  20GB           public    
34902021  6.9 x64            CentOS         centos-6-x64          snapshot  20GB           public    
43507983  v1.4.3             RancherOS      rancheros-1.4         snapshot  20GB           public    
45203822  29 x64             Fedora         fedora-29-x64         snapshot  20GB           public    
47384041  30 x64             Fedora         fedora-30-x64         snapshot  20GB           public    
49532121  12.0 x64 zfs       FreeBSD        freebsd-12-0-x64-zfs  snapshot  20GB           public    
49532140  12.0 x64 ufs       FreeBSD        freebsd-12-0-x64-ufs  snapshot  20GB           public    
49532500  11.3 x64 zfs       FreeBSD        freebsd-11-x64-zfs    snapshot  20GB           public    
49532502  11.3 x64 ufs       FreeBSD        freebsd-11-x64-ufs    snapshot  20GB           public    
50903182  7.6 x64            CentOS         centos-7-x64          snapshot  20GB           public    
51286794  v1.5.4             RancherOS      rancheros             snapshot  20GB           public    
53621447  9.7 x64            Debian         debian-9-x64          snapshot  20GB           public    
53871280  19.10 x64          Ubuntu         ubuntu-19-10-x64      snapshot  20GB           public    
53884440  19.04 x64          Ubuntu         ubuntu-19-04-x64      snapshot  20GB           public    
53893572  18.04.3 (LTS) x64  Ubuntu         ubuntu-18-04-x64      snapshot  20GB           public    
54203610  16.04.6 (LTS) x32  Ubuntu         ubuntu-16-04-x32      snapshot  20GB           public    
55022766  16.04.6 (LTS) x64  Ubuntu         ubuntu-16-04-x64      snapshot  20GB           public    
55826418  2331.1.0 (beta)    CoreOS         coreos-beta           snapshot  20GB           public    
```
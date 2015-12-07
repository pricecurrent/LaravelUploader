# Laravel Uploader.

If you're anything like me, you probably find yourself facing that you need to tacke file uploading from app to app, and you just manually wright things over and over again. Should this be repetitive? ***No***.

Instead, delegate this job to package which has only responsibility - uploading files.

## Install

Pull this package in through Composer.

```js
{
    "require": {
        "almazik/laravel-uploader": "dev-master"
    }
}
```

Then you'll need to reference the Service Provider Class. Insert this line into your `config/app.php` file, just append to `providers` array.

```php
Almazik\LaravelUploader\FileUploaderServiceProvider::class,
```

For your convinience, you might also want to reference the facade.

```php
'Uploader' => Almazik\LaravelUploader\Facades\Uploader::class,
```

## Usage

Let's assume we have a form for uploading a file, and controller's method to handle when it posts to it.

Here's an example.

```php
use Uploader;
use Illuminate\Http\Request;

class SomeController extends Controller {

    public function upload(Request $request)
    {
        Uploader::file($request->file('file'));
        Uploader::push('path/where/to/save');
    }
}

```

If you don't want to use facade, use dependency injection:

```php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Almazik\LaravelUploader\Contracts\Uploader;

class SomeController extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function upload(Request $request)
    {
        $this->uploader
            ->file($request->file('file'))
            ->push('path/to/store/file');
    }
}
```

You can chain methods.

### Input Sources
Currently package supports 2 input types: files uploaded through the form (as described above) and base64_encoded version of the file.

Imaging that you integrating some kind of third party api that would send you files in base64_encoded format. Easy enough:

class SomeController extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function upload(Request $request)
    {
        $encoded = $this->someService->getBase64Encoded();

        $this->uploader
            ->file($encoded)
            ->filename('foobar.jpg')
            ->push('path/to/store/file');
    }
}
```

Just notice that in this case you'll likely want to explicitly tell the filename to use as the package itself will try to lookup the given file mime-type and associate it with extension, but this doesn't work 100% of the times as not every mime-type has a fixed extension.

## Destination

The package uses Laravel's filesystem, so it has built in support for all drivers as Laravel does: local, s3, ftp, rackspace.

Be sure to check configs in `config/filesystem.php` to set up the path where your files will be uploaded.

For example, let's assume in your `config/filesystem.php` your default driver set to s3.

```php
'default' => 's3',

'disks' => [
    's3' => [
        'driver' => 's3',
        'key'    => env('S3_KEY'),
        'secret' => env('S3_SECRET'),
        'region' => env('S3_REGION'),
        'bucket' => env('S3_BUCKET'),
    ],
]
```

With these settings along, your file will be uploaded to your bucket being as the root and path that was passed in as an argument to push method.

## FileNames
By default, file will be uploaded with the original file name, being prefixed with the current timestamps and all whitespaces being replaced with underscores. If you want to override this, you can do this before calling the `push` method

```php
Uploader::filename('foo.png');
```

## Persisting

After uploading a file, you'll probably want to save the path to the DB, right? No probs, after uploading the file, just get the full path like this

```php
$fullPath = Uploader::getFullPath();
```

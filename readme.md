## PHP Class generator from Array
This package simulates creating a PHP Model class from a csv file (hard coded PHP array)

### Install 
``$ cd .docker && docker-compose up --build -d ``

### Create new symfony application
``$ docker exec -it demo_php bash``

#### Run test
``$ php ./vendor/bin/phpunit``


### Instructions 
- Make a GET request to http://localhost/generate/class
- A new class file should be created at ``public/Model/IndirectEmissionsOwned/Electricity/MeetingRooms.php``
- FIle content should be 

```php
<?php
namespace App\Model\IndirectEmissionsOwned\Electricity;

use Illuminate\Database\Eloquent\Model;

class MeetingRooms extends Model
{
    const TABLE_NAME = "meeting-rooms";

    public function getTableName(): string
    {
        return self::TABLE_NAME;
    }
}
```
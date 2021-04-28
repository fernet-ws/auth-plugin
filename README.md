# DoctrineFernet 

Doctrine plugin for the Fernet framework

## Configuration

Add the configuration to your .env:

```ini
DB_DRIVER="pdo_sql"
DB_USER="root"
DB_PASSWORD="your-password"
DB_NAME="my-database"
```

If you set up the plugin manually don't forget to add **"fernet/doctrine"** to the plugins.json file.

## Usage

Add your entities classes in the **src\Entity** folder with the **App\Entity** namespace.

```php
<?php
namespace App\Entity;

/** @Entity */
class Post
{
    /** @Id @Column(type="integer") @GeneratedValue */
    public int $id;
    /** @Column(type="string") */
    public string $title;
    /** @Column(type="text") */
    public string $content;
}
```

Then run Doctrine with the command  **vendor/bin/doctrine orm:validate-schema**. To create the database you can run
**orm:schema-tool:create** and to keep the database schema updated **orm:schema-tool:update**.

Use the **Doctrine\ORM\EntityManager** object in your components, for example with this <ShowPost id="1">

```php
<?php
namespace App\Component;

use App\Entity\Post;
use Doctrine\ORM\EntityManager;

class ShowPost
{
    public $id;

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __toString(): string
    {
        $post = $this->entityManager->find(Post::class, $this->id);
        return "<h1>{$post->title}</h1><section>{$post->content}</section>";
    }
}
```

For more information go to the [Doctrine documentation](https://www.doctrine-project.org/projects/orm.html).

## Repository

To use the Fernet autowire you can extends your Repository class to **DoctrineFernet\EntityRepository** and implements the **getEntity** method returning the entity class name.

```php
<?php
namespace App\Repository;

use App\Entity\Post;
use DoctrineFernet\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getEntity(): string
    {
        return Post::class;
    }
}
```

<?php  namespace Ninjaparade\Products\Laravel;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Ninjaparade\Products\Repositories\DbPackageRepository;
use Ninjaparade\Products\Repositories\DbProductRepository;


class ExtensionServiceProvider extends ServiceProvider {


    public function boot()
    {

    }


    public function register()
    {
        $this->registerProducts();

        $this->registerPackages();

        $this->registerBladeExtension();

        $this->app->register('Ninjaparade\Products\Laravel\ProductServiceProvider');
        AliasLoader::getInstance()->alias('Store', 'Ninjaparade\Products\Laravel\Facades\Product');
    }

    public function registerProducts()
    {
        $ProductRepository = 'Ninjaparade\Products\Repositories\ProductRepositoryInterface';

        if ( !$this->app->bound($ProductRepository) )
        {
            $this->app->bind($ProductRepository, function ($app)
            {
                $model = get_class($app['Ninjaparade\Products\Models\Product']);

                return new DbProductRepository($model, $app['events']);
            });
        }
    }

    public function registerPackages()
    {
        $PackageRepository = 'Ninjaparade\Products\Repositories\PackageRepositoryInterface';

        if ( !$this->app->bound($PackageRepository) )
        {
            $this->app->bind($PackageRepository, function ($app)
            {

                $model = get_class($app['Ninjaparade\Products\Models\Package']);

                $media = $app['Platform\Media\Repositories\MediaRepositoryInterface'];

                $product = $app['Ninjaparade\Products\Repositories\ProductRepositoryInterface'];

                return new DbPackageRepository($model, $app['events'], $media, $product);
            });
        }
    }


    /**
     *
     */
    public function registerBladeExtension()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->extend(function ($value) use ($blade)
        {
            $matcher = '/(\s*)@formPackage(\(.*?\)\s*)/';

            return preg_replace($matcher, "<?php echo with(new Ninjaparade\Products\Widgets\PackageForm())->show$2; ?>", $value);

        });
    }
}
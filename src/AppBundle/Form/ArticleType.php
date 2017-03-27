<?php

namespace AppBundle\Form;

use Comur\ImageBundle\Form\Type\CroppableImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // get your entity related with your form type
        $myEntity = $builder->getForm()->getData();

        $builder
            ->add('title')
            ->add('image', CroppableImageType::class, array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload', 		//optional
                    'uploadUrl' => $myEntity->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $myEntity->getUploadDir(),				// required - see explanation below (you can also put just a dir path)
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg', 	//optional
                    'libraryDir' => null, 						//optional
                    'libraryRoute' => 'comur_api_image_library', //optional
                    'showLibrary' => true, 						//optional
                    'saveOriginal' => 'originalImage',			//optional
                    'generateFilename' => true			//optional
                ),
                'cropConfig' => array(
                    'minWidth' => 588,
                    'minHeight' => 300,
                    'aspectRatio' => true, 				//optional
                    'cropRoute' => 'comur_api_crop', 	//optional
                    'forceResize' => false, 			//optional
                    'thumbs' => array( 					//optional
                        array(
                            'maxWidth' => 180,
                            'maxHeight' => 400,
                            'useAsFieldImage' => true  //optional
                        )
                    )
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'AppBundle\Entity\Article',
            ])
        ;
    }

    public function getName()
    {
        return 'app_bundle_article_type';
    }
}

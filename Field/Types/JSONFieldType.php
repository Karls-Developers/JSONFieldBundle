<?php

namespace Karls\JSONFieldBundle\Field\Types;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Router;
use UniteCMS\CoreBundle\Exception\ContentAccessDeniedException;
use UniteCMS\CoreBundle\Exception\ContentTypeAccessDeniedException;
use UniteCMS\CoreBundle\Exception\DomainAccessDeniedException;
use UniteCMS\CoreBundle\Exception\InvalidFieldConfigurationException;
use UniteCMS\CoreBundle\Exception\MissingContentTypeException;
use UniteCMS\CoreBundle\Exception\MissingDomainException;
use UniteCMS\CoreBundle\Exception\MissingOrganizationException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use UniteCMS\CoreBundle\Entity\Content;
use UniteCMS\CoreBundle\Entity\FieldableContent;
use UniteCMS\CoreBundle\Entity\FieldableField;
use UniteCMS\CoreBundle\Form\ReferenceType;
use UniteCMS\CoreBundle\SchemaType\IdentifierNormalizer;
use UniteCMS\CoreBundle\Security\Voter\DomainVoter;
use UniteCMS\CoreBundle\View\ViewTypeInterface;
use UniteCMS\CoreBundle\View\ViewTypeManager;
use UniteCMS\CoreBundle\Entity\View;
use UniteCMS\CoreBundle\Entity\ContentType;
use UniteCMS\CoreBundle\Entity\Domain;
use UniteCMS\CoreBundle\Field\FieldType;
use UniteCMS\CoreBundle\Security\Voter\ContentVoter;
use UniteCMS\CoreBundle\Service\UniteCMSManager;
use UniteCMS\CoreBundle\SchemaType\SchemaTypeManager;
use UniteCMS\CoreBundle\Field\FieldableFieldSettings;
use Symfony\Component\DependencyInjection\Container;

class JSONFieldType extends FieldType
{
    const TYPE = "json";
    const FORM_TYPE = HiddenType::class;

    private $settings;

    private $entityManager;

    /**
     * @var Container
     */
    private $container;

    /**
     * SlugFieldType constructor.
     * @param EntityManagerInterface $entityManager
     * @param Container $container
     */
    public function __construct(EntityManagerInterface $entityManager, Container $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    function getFormOptions(FieldableField $field): array
    {
        $this->settings = (array) $field->getSettings();

        return parent::getFormOptions($field);
    }

    /**
     * {@inheritdoc}
     */
    function getGraphQLInputType(FieldableField $field, SchemaTypeManager $schemaTypeManager, $nestingLevel = 0) {
        return $schemaTypeManager->getSchemaType('JSONFieldInput');
    }

    /**
     * {@inheritdoc}
     */
    function resolveGraphQLData(FieldableField $field, $value, FieldableContent $content)
    {
        // return NULL on empty value
        if (empty($value))
        {
            return NULL;
        }
//        return (string) $value;
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    function validateSettings(FieldableFieldSettings $settings, ExecutionContextInterface $context)
    {
        // Validate allowed and required settings.
        parent::validateSettings($settings, $context);

        // Only continue, if there are no violations yet.
        if ($context->getViolations()->count() > 0) {
            return;
        }
    }

//    /**
//     * {@inheritdoc}
//     */
//    function validateData(FieldableField $field, $data, ExecutionContextInterface $context) {
//        if (empty($data) || !count($context->getValue()) || !$this->settings['source']) {
//            return;
//        }
//
////        $this->checkIfSlugStillExists($this->slugify($context->getValue()[$this->settings['source']]), $context, $field->getContentType());
//    }

//    /**
//     * {@inheritdoc}
//     */
//    public function onCreate(FieldableField $field, FieldableContent $content, EntityRepository $repository, &$data) {
//        if(isset($this->settings['source'])) {
//            $data["slug"] = $this->slugify($data[$this->settings['source']]);
//            $content->setData($data);
//            $this->container->get('validator')->validate($content);
//        }
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function onUpdate(FieldableField $field, FieldableContent $content, EntityRepository $repository, $old_data, &$data) {
//        if(isset($this->settings['source'])) {
//            $data["slug"] = $this->slugify($data[$this->settings['source']]);
//            $content->setData($data);
//            $this->container->get('validator')->validate($content);
//        }
//    }
}
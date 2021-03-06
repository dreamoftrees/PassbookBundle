<?php

namespace Eo\PassbookBundle\Controller;

use Passbook\Pass\Field;
use Passbook\PassFactory;
use Passbook\Pass\Barcode;
use Passbook\Pass\Structure;
use Passbook\Type\EventTicket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Get pass factory
        $factory = $this->get('pass_factory');

        // Create an event ticket
        $ticket = new EventTicket("1234567890", "The Beat Goes On");
        $ticket->setBackgroundColor('rgb(60, 65, 76)');
        $ticket->setLogoText('Apple Inc.');

        // Create pass structure
        $structure = new Structure();

        // Add primary field
        $primary = new Field('event', 'The Beat Goes On');
        $primary->setLabel('Event');
        $structure->addPrimaryField($primary);

        // Add secondary field
        $secondary = new Field('location', 'Moscone West');
        $secondary->setLabel('Location');
        $structure->addSecondaryField($secondary);

        // Add auxiliary field
        $auxiliary = new Field('datetime', '2013-04-15 @10:25');
        $auxiliary->setLabel('Date & Time');
        $structure->addAuxiliaryField($auxiliary);

        // Set pass structure
        $ticket->setStructure($structure);

        // Add barcode
        $barcode = new Barcode('PKBarcodeFormatQR', 'barcodeMessage');
        $ticket->setBarcode($barcode);

        // Create pass file
        $pass = $factory->package($ticket);

        return $this->render('EoPassbookBundle:Default:index.html.twig', array(
            'pass'       => $pass,
            'controller' => __FILE__
        ));
    }
}

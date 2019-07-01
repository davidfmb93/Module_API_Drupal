<?php
namespace Drupal\test_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;


class TestController extends ControllerBase {

/* Método acción content devuelve directamente un contenido en html,
este método será usado en una ruta */
  public function content($content) {

    $path = \Drupal::service('path.alias_manager')->getPathByAlias('/'.$content);
    $node_id  = explode('/node/',$path)[1];

    //Si no existe el nodo devuelve null
    if(!$node_id){
      return new JsonResponse(    
        array(
        'data' => null
      ));
    }

    $json_array = array(
      'data' => array()
    );
    $node =   Node::load($node_id );

    switch ($node->get('type')->target_id) {
      case 'template_one':
        $json_array =  $this->template_one($node);
        break;
      
      case 'template_two':
        $json_array =  $this->template_two($node);
        break;

      case 'template_three':
        $json_array =  $this->template_three($node);
        break;

      default:
        # code...
        break;
    }
    return new JsonResponse($json_array);
  }




  /**
   * {@inheritdoc}
   * 
   * Quitamos el cache del bloque.
   */
  public function getCacheMaxAge() {
      return 0;
  }

/**
 * Data Template uno
 * 
 * Contiene toda la informaciòn para renderizar.
 */
  public function template_one($node){
    $json_array['data'][] = array(
      'type' => $node->get('type')->target_id,
      'id' => $node->get('nid')->value,
      'attributes' => array(
        'logo' =>  $this->array_images($node->field_logo),
        'title' =>  $this->array_images($node->field_title),
        'content' => $node->body->getValue(),
        'neighborhood' => $node->field_barrio->getValue(),
        'city' => $node->field_ciudad->getValue(),
        'pricefrom' => $node->field_precio_desde->getValue(),
        'description' => $node->field_descripcion->getValue(),
        'slogan' => $node->field_slogan->getValue(),
        'map' => $this->array_images($node->field_imagen_de_mapa),
        'characteristics' => $this->array_images($node->field_zonas),
        'photos' => $this->array_images($node->field_fotos),
        'address' => $node->field_direccion->getValue(),
        'waze' => $node->field_url_waze->getValue(),
        'phone' => $node->field_telefono->getValue(),
        'email' => $node->field_correo->getValue(),
      ),
    );
    return  $json_array;
  }


/**
 * Data Template uno
 * 
 * Contiene toda la informaciòn para renderizar.
 */
public function template_two($node){
  $json_array['data'][] = array(
    'type' => $node->get('type')->target_id,
    'id' => $node->get('nid')->value,
    'attributes' => array(
      'logo' =>  $this->array_images($node->field_logo_two),
       'title' =>  $this->array_images($node->field_title_two),
      'neighborhood' => $node->field_barrio_two->getValue(),
      'city' => $node->field_ciudad_two->getValue(),
      'pricefrom' => $node->field_precio_desde_two->getValue(),
      'characteristics' => $this->array_images($node->field_caracteristicas_two),
      'photos' => $this->array_images($node->field_fotos_two),
      'zonas' => $node->field_zonas_two->getValue(),
      'address' => $node->field_direccion_two->getValue(),
      'waze' => $node->field_waze_two->getValue(),
      'map' => $this->array_images($node->field_imagen_de_mapa_two),
      'phone' => $node->field_telefono_two->getValue(),
      'email' => $node->field_correo_two->getValue(), 
    ),
  );
  return  $json_array;
}

/**
 * Data Template tres
 * 
 * Contiene toda la informaciòn para renderizar.
 */
public function template_three($node){
  $json_array['data'][] = array(
    'type' => $node->get('type')->target_id,
    'id' => $node->get('nid')->value,
    'attributes' => array(
      'title' =>  $this->array_images($node->field_title_three),
      'logo' =>  $this->array_images($node->field_logo_three),
      'pricefrom' => $node->field_precio_desde_three->getValue(),
      'address' => $node->field_direccion_three->getValue(),
      'waze' => $node->field_url_waze_three->getValue(),
      'zonas' => $node->field_zonas_three->getValue(),
      'Area' => $node->field_area_construida_three->getValue(),
      'photos' => $this->array_images($node->field_fotos_three),
      'footer' => $this->array_images($node->field_footer),
      'phone' => $node->field_telefono_three->getValue(),
      'email' => $node->field_correo_three->getValue(),
      'neighborhood' => $node->field_barrio_three->getValue(),

    ),
  );
  return  $json_array;
}


  /**
   * Colocamos la url de las imagenes al mometo de generar la 
   * informacion de esta.
   * 
   */
  public function array_images($node){
    $images = [];
    foreach ($node as $key => $value) {
      # code...
      $data = [
        'url' => file_create_url($value->entity->uri->value),
        'value' => $value->getValue(),
      ];
      array_push($images, $data);
    }
    return $images;
  }
   
}
 
?>

<?php
namespace Drupal\test_module\Plugin\Block;
 
use Drupal\Core\Block\BlockBase;
/**
 * Definición de nuestro bloque
 *
 * @Block(
 *   id = "test_block",
 *   admin_label = @Translation("test block")
 * )
 */
class TestBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        return [
            '#type' => 'markup',
            '#markup' => 'David asi seas un grunon, te amo muchooo!!',
        ];
    }
}

<?php
/**
 * EkShipping
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * EkShipping MatrixRate
 *
 * @category EkShipping
 * @package EkShipping_MatrixRate
 * @copyright Copyright (c) 2014 Zowta LLC (http://www.emanuelkadiasi.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author EkShipping Team emanuel.kadiasi@emanuelkadiasi.com
 *
 */
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace EkShipping\MatrixRate\Model\Config\Source;

class Matrixrate implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \EkShipping\MatrixRate\Model\Carrier\Matrixrate
     */
    protected $_carrierMatrixrate;

    /**
     * @param \EkShipping\MatrixRate\Model\Carrier\Matrixrate $carrierMatrixrate
     */
    public function __construct(\EkShipping\MatrixRate\Model\Carrier\Matrixrate $carrierMatrixrate)
    {
        $this->_carrierMatrixrate = $carrierMatrixrate;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $arr = [];
        foreach ($this->_carrierMatrixrate->getCode('condition_name') as $k => $v) {
            $arr[] = ['value' => $k, 'label' => $v];
        }
        return $arr;
    }
}
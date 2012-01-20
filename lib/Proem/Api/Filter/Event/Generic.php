<?php

/**
 * The MIT License
 *
 * Copyright (c) 2010 - 2012 Tony R Quilkey <trq@proemframework.org>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


/**
 * @namespace Proem\Api\Filter\Event
 */
namespace Proem\Api\Filter\Event;

use Proem\Filter\Chain,
    Proem\Service\Manager;

/**
 * Proem\Api\Filter\Event\Generic
 */
abstract class Generic
{
    /**
     * inBound
     *
     * Define the method to be called on the way into the chain.
     */
    public abstract function inBound(Manager $assets);

    /**
     * outBound
     *
     * Define the method to be called on the way out of the chain.
     */
    public abstract function outBound(Manager $assets);

    /**
     * init
     *
     * Call inBound(), the next event in the chain, then outBound()
     *
     * @param Proem\Api\Filter\Chain $chain
     * @return Proem\Api\Filter\Chain
     */
    public function init(Chain $chain)
    {
        $this->inBound($chain->getServiceManager());

        if ($chain->hasEvents()) {
            $event = $chain->getNextEvent();
            if (is_object($event)) {
                $event->init($chain);
            }
        }

        $this->outBound($chain->getServiceManager());

        return $this;
    }
}
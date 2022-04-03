<?php

namespace Pioc\IocPhp\ioc;

use Exception;

/**
 * {@code DisposableBean}
 * the mark of the bean disposable.
 *
 * @author photowey
 * @date 2022/04/03
 * @since 1.0.0
 */
interface DisposableBean
{
    /**
     * {@code bean} 的销毁
     * @param string $bean {@code bean} 名称
     * @return bool
     * @throws Exception
     */
    public function destroy(string $bean): bool;

    /**
     * {@code bean} 的销毁
     * @param string $clazz {@code bean} 类名称
     * @return bool
     * @throws Exception
     */
    public function destroyz(string $clazz): bool;
}
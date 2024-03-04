<ul class="pagination">
    <!-- Si la página actual es mayor a uno, mostramos el botón para ir una página atrás -->
    <?php 
    $pagination_url = add_query_arg('pagina', $pagina - 1, get_permalink($current_page_id));
    if ($pagina > 1) { ?>
    	<li>
            <a href="<?php echo $pagination_url; ?>">
                <span aria-hidden="true">&laquo; Anterior</span>
            </a>
        </li>
    <?php } ?>

    <!-- Mostramos enlaces para ir a todas las páginas. Es un simple ciclo for-->
    <?php for ($x = 1; $x <= $paginas; $x++) { 
    	$pagination_url = add_query_arg('pagina', $x, get_permalink($current_page_id));
    ?>
    	<li class="<?php if ($x == $pagina) echo "active" ?>">
           	<a href="<?php echo $pagination_url; ?>">
                <?php echo $x ?>
            </a>
        </li>
    <?php } ?>
    <!-- Si la página actual es menor al total de páginas, mostramos un botón para ir una página adelante -->
    <?php if ($pagina < $paginas) { 
    	$pagination_url = add_query_arg('pagina', $pagina + 1, get_permalink($current_page_id));
    ?>
    	<li>
            <a href="<?php echo $pagination_url; ?>">
                <span aria-hidden="true">Siguiente &raquo;</span>
            </a>
        </li>
    <?php } ?>
</ul>
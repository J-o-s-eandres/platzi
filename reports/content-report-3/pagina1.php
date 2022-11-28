<page>

<!-- Cabecera -->
<page_header>
    <p><?=$cabecera?></p>
    <hr class="b-simple">
</page_header>

<!-- Pie -->
<page_footer>
<p class="center italic tl"><?=$piePagina?> /Pág.#[[page_cu]]</p>
</page_footer>

<!-- Cuerpo de la página -->
    <div class="mt-5" >
        <h3 class="center">Reporte de Cursos</h3>
        <hr>

        <table class="tfull">
            <thead>
                <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:15%;">Escuela</th>
                    <th style="width:20%;">Titulo</th>
                    <th style="width:25%;">Dificultad</th>
                    <th style="width:10%;">Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listaCursos as $curso): ?>
                    <tr>
                        <td class="center mb-4 bold tl"><?=$curso["idcurso"]?></td>
                        <td class="mt-2 italic tl"><?=$curso["escuela"]?></td>
                        <td class="mt-2 italic tl"><?=$curso["titulo"]?></td>
                        <td class="mt-2 italic tl"><?=$curso["dificultad"]?></td>
                        <td class="italic"><?=$curso["precio"]?></td>
                    </tr>
                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
</page>
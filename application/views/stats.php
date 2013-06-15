<section id="stats">
    <h2>
        Statistiques
    </h2>

    <table id="quizzStats">
        <thead>
            <tr>
                <th>
                    Date
                </th>
                <th>
                    Nombre de joueurs
                </th>
                <th>
                    Parties finies
                </th>
                <th>
                    Moyenne de bonnes réponses
                </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach( $stats as $stat ) :
            ?>
                <tr>
                    <th>
                        <?= $stat['date'] ?>
                    </th>
                    <td>
                        <?php 
                            $visit =  isset($stat['nbPlayer']) ? $stat['nbPlayer'] : 0;
                            echo $visit;
                        ?>
                    </td>
                    <td>
                        <?php 
                            $click =  isset($stat['nbFini']) ? $stat['nbFini'] : 0;
                            echo $click;
                        ?>
                    </td>
                    <td>
                        <?php 
                            $click =  isset($stat['avgRep']) ? round($stat['avgRep'], 2) : 0;
                            echo $click;
                        ?>
                    </td>
                </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
</section>
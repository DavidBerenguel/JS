<?php
    require("config.php");

    if(isset($_POST["send"]) && intval($_POST["quantity"]) > 0) {
        
        $query = $db->prepare("
            SELECT product_id, name, price, stock
            FROM products
            WHERE product_id = ?
              AND stock >= ?
        ");

        $query->execute([
            $_POST["product_id"],
            $_POST["quantity"]
        ]);

        $product = $query->fetch( PDO::FETCH_ASSOC );

        if(!empty($product)) {

            $_SESSION["cart"][ $product["product_id"] ] = [
                "product_id" => $product["product_id"],
                "quantity" => intval($_POST["quantity"]),
                "name" => $product["name"],
                "price" => $product["price"],
                "stock" => $product["stock"]
            ];
        }

        /* forçar que o utilizador entre na página
           novamente mas por GET em vez de POST */
        header("Location: cart.php");
    }
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Carrinho</title>
        <script>
            document.addEventListener("DOMContentLoaded", () =>{

                const btnRemove = document.querySelectorAll(".btnRemove");
                const changeQnt = document.querySelectorAll(".change-quantity");

                function sumTotal() {

                    let total = 0;
                            const subTotals = document.querySelectorAll(".subtotal");
                            
                            for(let subtotalTd of subTotals) {
                                
                                console.log("Subtotal:", subtotalTd.dataset.subtotal);
                                total += Number(subtotalTd.dataset.subtotal);
                                
                            }

                            console.log("Total:", total);
                            document.querySelector(".total").textContent = total + "€";
                }

                // É o mesmo que escrever ---->  let i = 0; i < btnRemove.length; i++
                for (let change of changeQnt) {

                    change.addEventListener("change", () => {

                        /* Quando precisamos de fazer uma comparação com números, 
                        mas o JS por erro esta a trabalhar com strings, 
                        temos de conver ter (CAST) para o datatype correto*/
                        const max = parseInt(change.max);
                        const quantity = parseInt(change.value);

                        const tr = change.parentElement.parentElement;
                        const product_id = tr.dataset.product_id;

                        if (quantity <= max) {

                            fetch("requests.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type":"application/x-www-form-urlencoded"
                                },
                                body: `request=changeQuantity&product_id=${product_id}&quantity=${quantity}`
                            })
                            .then(response => response.json())
                            .then(result => {
 
                                const price = tr.children[2].dataset.price;
                                
                                tr.children[3].textContent = (price * quantity) + "€";
                                tr.children[3].dataset.subtotal = price * quantity;
                                //tr.children[3].setAttribute("data-subtotal", price * quantity);

                                sumTotal();
                                
                            });
                        }
                    });
                }
                
                for (let button of btnRemove) {

                    button.addEventListener("click", () => {

                        const tr = button.parentElement.parentElement;
                        const product_id = tr.dataset.product_id;

                        fetch("requests.php", {
                            method: "POST",
                            headers: {
                                "Content-Type":"application/x-www-form-urlencoded"
                            },
                            body: "request=removeProduct&product_id=" + product_id

                        })
                        .then(response => response.json())
                        .then(result => {
                            
                            tr.remove();

                            sumTotal();

                        });
                    });
                }


            });
        </script>
        <style>
            table, tr, th, td {
                border: 1px solid #000;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
<?php
    if( !empty($_SESSION["cart"]) ) {
?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Subtotal</th>
                <th>Remover</th>
            </tr>
<?php
        $total = 0;

        foreach($_SESSION["cart"] as $item) {

            $subtotal = $item["price"] * $item["quantity"];
            $total += $subtotal;

            echo '
                <tr data-product_id="' . $item["product_id"] . '">
                    <td>' .$item["name"]. '</td>
                    <td>
                       <input 
                            type="number" 
                            class="change-quantity" 
                            value="' .$item["quantity"]. '" 
                            min="1" 
                            max="' .$item["stock"]. '"> 
                    </td>
                    <td class="price" data-price="' .$item["price"]. '">' .$item["price"]. '€</td>
                    <td class="subtotal" data-subtotal="' .$subtotal. '">' .$subtotal. '€</td>
                    <td>
                        <button 
                            class="btnRemove" 
                            type="button" 
                            arial-label="Remove Artigo"
                        >X</button>
                    </td>
                </tr>
            ';
        }
?>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="total"><?php echo $total; ?>€</td>
            </tr>
        </table>
<?php
    }
    else {
        echo "<p>Ainda não tem nada no carrinho</p>";
    }
?>
        <nav>
            <a href="./">Voltar à Home</a>
            <a href="checkout.php">Efectuar Encomenda</a>
        </nav>
    </body>
</html>

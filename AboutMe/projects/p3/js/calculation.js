
            function max() {
                var num1 = document.getElementById("number1").value;
                var num2 = document.getElementById("number2").value;
                var num3 = document.getElementById("number3").value;
                if (parseInt(num1) >= parseInt(num2) && parseInt(num1) >= parseInt(num3))
                {
                    document.getElementById("max").innerHTML = num1;
                }
                else if (parseInt(num2) >= parseInt(num1) && parseInt(num2) >= parseInt(num3))
                {
                    document.getElementById("max").innerHTML = num2;
                }
                else
                {
                    document.getElementById("max").innerHTML = num3; 
                }
            }
            function min() {
                var num1 = document.getElementById("number1").value;
                var num2 = document.getElementById("number2").value;
                var num3 = document.getElementById("number3").value;
                if (parseInt(num1) <= parseInt(num2) && parseInt(num1) <= parseInt(num3))
                {
                    document.getElementById("min").innerHTML = num1;
                }
                else if (parseInt(num2) <= parseInt(num1) && parseInt(num2) <= parseInt(num3))
                {
                    document.getElementById("min").innerHTML = num2;
                }
                else
                {
                    document.getElementById("min").innerHTML = num3; 
                }
            }
            function avg() {
                var num1 = document.getElementById("number1").value;
                var num2 = document.getElementById("number2").value;
                var num3 = document.getElementById("number3").value;
                document.getElementById("average").innerHTML = ((parseInt(num1) + parseInt(num2) + parseInt(num3)) / 3).toFixed(2);
            }
            function med() {
                var num1 = document.getElementById("number1").value;
                var num2 = document.getElementById("number2").value;
                var num3 = document.getElementById("number3").value;
                var max = document.getElementById("max").innerHTML;
                var min = document.getElementById("min").innerHTML;
                if (num1 != max && num1 != min)
                {
                    document.getElementById("median").innerHTML = num1;
                }
                else if (num2 != max && num2 != min)
                {
                    document.getElementById("median").innerHTML = num2;
                }
                else
                {
                    document.getElementById("median").innerHTML = num3;
                }
            }
            function range(){
                var max = document.getElementById("max").innerHTML;
                var min = document.getElementById("min").innerHTML;
                document.getElementById("range").innerHTML = max - min;
            }
      
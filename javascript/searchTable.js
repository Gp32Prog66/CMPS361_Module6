function searchTable()
{
    var input, filter, table, tr, td, i, j, txtValue;

    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("dataGrid");

    tr = table.getElementByTagname("tr");

    //Loop
    for (i = 1; i < tr.length; i++) //Starts at 1 to skip header
    {
        tr[i].style.display = "none"; //Hide rows initially
        td = tr[i].getElementByTagname("td");

        for (j = 0; j < td.length; j++) //Looping Each Cell in the Row
        {
            if (td[j])
            {
                txtValue = td[j].textContent || td[j].innerText;
                if (textValue.toLowerCase().indexOf(filter) > -1 )
                {
                    tr[i].style.display = ""; //show the row if a match is located
                    break;
                }
            }
        }
    }
}
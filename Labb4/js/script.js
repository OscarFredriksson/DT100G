document.getElementById("part1_btn").addEventListener("click", function()
{
    window.location.href="index.php?part=1";
});

document.getElementById("part2_btn").addEventListener("click", function()
{
    window.location.href="index.php?part=2";
});

function buttonClicked(e)
{
    window.location.href = window.location.href + "&delete=" + e.id;
}
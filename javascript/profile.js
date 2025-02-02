function updateRightSide(option) {
    fetch(`../actions/update_right_side_profile.php?option=${option}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('right-side').innerHTML = data;
        });
}

updateRightSide('personalData');
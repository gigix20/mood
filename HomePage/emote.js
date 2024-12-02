document.addEventListener('DOMContentLoaded', function () {
    const smileRadio = document.getElementById('smile-radio');
    const emoticonOptions = document.getElementById('emoticon-options');
    const grinIcon = smileRadio.nextElementSibling; // The <i> element for the grin icon
    let currentEmoticon = ''; // Store the currently selected emoticon

    // Function to handle emoticon options display
    const showEmoticonOptions = () => {
        emoticonOptions.style.display = 'block'; 
    };


    const handleEmoticonSelection = () => {
        const emoticonOptionsList = document.querySelectorAll('input[name="emoticon-option"]');

        emoticonOptionsList.forEach(option => {
            option.addEventListener('change', function () {
                
                grinIcon.className = ''; 
                grinIcon.innerHTML = this.parentElement.querySelector('i').innerHTML;
                currentEmoticon = this.value;
                emoticonOptions.style.display = 'none'; 
            });
        });
    };


    grinIcon.addEventListener('click', function () {
        showEmoticonOptions();
    });

   
    handleEmoticonSelection();
})


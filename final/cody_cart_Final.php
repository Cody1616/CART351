<html>
  <head>
    <title> cody final </title>
    <link href="css/finalstyle.css", rel = "stylesheet", type="text/css">
    <script src="script/Tone.js"></script>
    <script src="jquery/jquery-3.3.1.min.js"></script>
  </head>

  <body>
    <script>
        window.onload = function(){
        let data = [];
         $.ajax({
                type: "POST",
                enctype: 'text/plain',
                url: "./script/retrieveData.php",
                data: "",
                processData: false,//prevents from converting into a query string
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (response) {
                console.log(response);
                //use the JSON .parse function to convert the JSON string into a Javascript object
                let parsedJSON = JSON.parse(response);
                console.log(parsedJSON);
                data = parsedJSON;
               },
                error:function(){
                  console.log("error occurred");
                }
              });
        // create a playhead that moves across the canvas and triggers notes it comes across
        let playHead1 = new playHead(10);
        let placePreview = new previewIcon();
        function drag(event){
          placePreview.drag(event);
        }
        let canvas = document.getElementById('NotesCanvas');
        let canvasContext = canvas.getContext('2d');
        document.getElementById("playButton").addEventListener("click", hitPlay);
        document.getElementById("stopButton").addEventListener("click", hitPause);
        document.getElementById("createButton").addEventListener("click", openMenu);
        document.getElementById("cancelButton").addEventListener("click", closeMenu);
        document.getElementById("createButton").addEventListener("click", previewIcon);
        document.getElementById("NotesCanvas").addEventListener("click", drag);
        document.getElementById("pckSpotBtn").addEventListener("click", closeMenu);
        // bool for position picking stage
        var preview = false;
        var d = new Date();
        var startTime = d.getTime();
        var timePassed;
        var startPlayNote;
        var timePassedPlayNote;
        // actual music notes associated with lines (in Hz since Tone does not recognize letter notes)
        let gamme = [1975, 1760, 1568, 1397, 1318, 1174, 1046,
                    987, 880, 784, 698, 659, 587, 554,
                    523, 493, 440, 392, 349, 330, 294,
                    262, 247, 220, 196, 174, 165, 147];
        let icons = [];

        // lines on which the notes will be placed
        let rows = [];
        for(let i = 0; i<28; i++){
          // alternate between visible and invisible lines
          // for notes that are on lines and between lines
          let x = 10*i+20;
          if(i%2 == 0){
            rows.push(new line(x, gamme[i%gamme.length], false));
          }
          else{
            rows.push(new line(x, gamme[i%gamme.length], true));
          }
        }
        // create and initialize an array of music notes (for testing purposes, they will be created by users in the final prototype)
        let notes = [];
        // for(let i = 0; i<10; i++){
        //   // display all notes. Currently at random for testing purposes.
        //   let v = Math.random()*rows.length;
        //   v -=v%1;
        //   notes.push(new musicNote(Math.random()*(canvas.width/3 - 20)+10, rows[v], 0));
        // }
        console.log(data);
        //notes.push(new musicNote(data.xPos, data.row, 0));
        for(let i = 0; i<data.length; i++){
            notes.push(new musicNote(data[i].xPos, data[i].row, 0));
          }


        //bars
        let bars = [];
        for(let i = 0; i<5; i++){
          bars.push(new bar(i*canvas.width/4, "black"));
        }
        // animate_______________animate__________________animate_____________________animate
        requestAnimationFrame(run);
        function run(){
          // new date to calculate time WITHIN the program
          var e = new Date();
          timePassed = e.getTime()-startTime;
          //clear canvas and run animation
          canvasContext.clearRect(0, 0, canvas.width, canvas.height);
          requestAnimationFrame(run);
          // update lines, notes, and playhead
          for(let i = 0; i<rows.length; i++){
            rows[i].display();
          }
          for(let i = 0; i<bars.length; i++){
            bars[i].display();
          }
          for(let i = 0; i<notes.length; i++){
            notes[i].display();
            notes[i].checkPlayHead();
          }
          playHead1.play();
          playHead1.display();
          if(preview){
            placePreview.display();
          }
        }
        // lines on which the notes are
        function line(y, n, v){
          this.yPos = y;
          this.note = n;
          this.vis = v; // visible or not - bool
          this.display = function(){
            // visible or not visible
            if(this.vis == false){
              canvasContext.strokeStyle = "#00000000";
            }
            if (this.vis == true){
              canvasContext.strokeStyle = "#000000";
            }
            // draw line
            canvasContext.lineWidth = 2;
            canvasContext.beginPath();
            canvasContext.moveTo(0, y);
            canvasContext.lineTo(canvas.width, y);
            canvasContext.stroke();
          }
        }
        //music notes/flowers
        function musicNote(x, r, a){
          // x should be the position on the timeline, y should be
          // the line/note the square is on
          this.xPos = x;
          // this.yPos = y;
          // this.note = n;
          this.row = r;
          this.Age = a;
          console.log(this.row);
          this.yPos = rows[this.row].yPos;
          this.note = this.row.note;
          this.playing = false; // if playing, then don't start the trigger attack again
          this.synth = new Tone.Synth().toMaster();
          // for eventual sprites - for now we'll use colors
          this.display = function(){
            //color dot for starters
            canvasContext.fillStyle = "green";
            canvasContext.strokeStyle = "black";
            canvasContext.lineWidth = 3;
            canvasContext.rect(this.xPos, this.yPos, 20, 20);
            canvasContext.stroke();
            canvasContext.fill()
            //canvasContext.drawImage("assets/icons/flower06.png", 20, 20);
          }
          this.checkPlayHead = function(){
            // checks if playhead is on note. if so, play tone
            if (playHead1.xPos > this.xPos && playHead1.xPos < this.xPos+20){
              if(this.playing == false){
                this.synth.triggerAttackRelease(this.note, "4n");
                this.playing = true;
              }
            }
            else {
              // if the playhead has moved on, then the sound should not be playing.
              this.playing = false;
            }
          }
          function getIcons(){
            //pick the correct icon
            switch(color){
              case 1: switch(shape){
                case 1:
                break;
                case 2:
                break;
                case 3:
                break;
                case 4:
                break;
                case 5:
                break;
              }
              break;
              case 2:switch(shape){
                case 1:
                break;
                case 2:
                break;
                case 3:
                break;
                case 4:
                break;
                case 5:
                break;
              }
              break;
              case 3:switch(shape){
                case 1:
                break;
                case 2:
                break;
                case 3:
                break;
                case 4:
                break;
                case 5:
                break;
              }
              break;
              case 4:switch(shape){
                case 1:
                break;
                case 2:
                break;
                case 3:
                break;
                case 4:
                break;
                case 5:
                break;
              }
              break;
              case 5:switch(shape){
                case 1:
                break;
                case 2:
                break;
                case 3:
                break;
                case 4:
                break;
                case 5:
                break;
              }
              break;
            }
          }
        }
        // a function for when the user hits the play button
        function hitPlay(){
          // create a new time to calculate the time passed since hitPlay
          // then generate playhead position accordingly
          let f = new Date();
          startPlayNote = f.getTime();
          timePassedPlayNote = 0;
          playHead1.playTime = timePassedPlayNote;  // get initial time to calculate time passed since the button was clicked
          playHead1.playing = true; // is the music playing?
        }
        // pause
        function hitPause(){
          // if pause is hit, then stop playing.
          playHead1.playing = false;
        }
        // this is still in progress
        function bar(x, c){
          // for bars
          //this.tempo = t; // how long they are
          this.xPos = x;
          this.color = c;
          this.display = function(){
            canvasContext.fillStyle = this.color;
            canvasContext.lineWidth = 2;
            canvasContext.beginPath();
            canvasContext.moveTo(x, 30);
            canvasContext.lineTo(x, canvas.height);
            canvasContext.stroke();
          }
        }
        // for the playhead
        function playHead(x){
          // only an x position, since its a vertical line that moves across the canvas
          this.xPos = x;
          this.display = function(){
            canvasContext.strokeStyle = "#000000"
            canvasContext.fillStyle = "#FF0000";
            canvasContext.lineWidth = 5;
            canvasContext.beginPath();
            canvasContext.moveTo(this.xPos, 0);
            canvasContext.lineTo(this.xPos, canvas.height);
            canvasContext.stroke();
          }
          // for when the music is playing
          this.play = function(){
            if (this.playing){
              let f = new Date();
              timePassedPlayNote = f.getTime() - startPlayNote;

              this.xPos = timePassedPlayNote/50;
            }
          }
          // initialize the variables
          this.playing = false; // bool - is the music playing
          this.playTime = 0;
        }
        //open the flower customization menu
        function openMenu(){
          document.getElementById("createNote").style.display = "block";
          preview = true;

        }
        //close the flower customization menu
        function closeMenu(){
          document.getElementById("createNote").style.display = "none";
          preview = false;
        }
        function previewIcon(){
          this.xPos = 0;
          // row position in the array
          this.r = 0;
          this.synth = new Tone.Synth().toMaster();
          this.display = function(){
            canvasContext.fillStyle = "#00FF00";
            canvasContext.rect(this.xPos, rows[this.r].yPos, 20, 20);
            console.log(this.r);
            canvasContext.stroke();
            canvasContext.fill()
          }
          // click and drag
          this.drag = function(event){
            if(preview == true){
              this.xPos = event.pageX;
              this.y = event.pageY;
              // snap to closest row
              let x = 0;
              for(let i = 0; i<rows.length; i++){
                if(Math.abs(rows[i].yPos-this.y) < Math.abs(rows[x].yPos-this.y)){
                  x = i;
                }
              }
              this.r = x;
              this.synth.triggerAttackRelease(rows[x].note, "4n");
            }
          }
          // on release - snap to nearest line
        }
        //__________________________________A___J___A___X______________________________//
        $("#FlowerPick").submit(function(event) {
          //stop submit the form, we will post it manually. PREVENT THE DEFAULT behaviour ...
          event.preventDefault();
          //console.log(placePreview.r);
          console.log("button clicked");
          let form = $('#FlowerPick')[0];
          let data = new FormData(form);
          data.append("row",placePreview.r);
          data.append("xPos",placePreview.xPos);
          $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "script/addToDB.php",
            data: data,
            processData: false,//prevents from converting into a query string
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
              //reponse is a STRING (not a JavaScript object -> so we need to convert)
              console.log(response);
              //use the JSON .parse function to convert the JSON string into a Javascript object
              //  let parsedJSON = JSON.parse(response);
              //  console.log(parsedJSON);
              //  displayResponse(parsedJSON);
            },
            error:function(){
              console.log("error occurred");
            }
          });
        });

    }
    </script>
    <canvas id="NotesCanvas" width = 1500 height = 310>
    </canvas>
    <div>
      <!-- button to play -->
      <button id="playButton" type="button">Play</button>
      <button id="stopButton" type="button">Stop</button>
      <br><br>
      <button id="createButton" type="button">Plant a flower</button>
    </div>
    <div id = "createNote" class = "form-popup">
      <h3>Select color and shape</h3>
      <div id=flowerPick>
        <form id = "FlowerPick">
          <input type="radio" name="color" value="1"> <span id = fColor1 class = circle></span>
          <input type="radio" name="color" value="2"> <span id = fColor2 class = circle></span>
          <input type="radio" name="color" value="3"> <span id = fColor3 class = circle></span>
          <input type="radio" name="color" value="4"> <span id = fColor4 class = circle></span>
          <input type="radio" name="color" value="5"> <span id = fColor5 class = circle></span>
          <br><br><br>
          <input type="radio" name="shape" value="1"> <img src="assets/icons/flower01.png" width = 50 height = 50>
          <input type="radio" name="shape" value="2"> <img src="assets/icons/flower02.png" width = 50 height = 50>
          <input type="radio" name="shape" value="3"> <img src="assets/icons/flower03.png" width = 50 height = 50>
          <input type="radio" name="shape" value="4"> <img src="assets/icons/flower04.png" width = 50 height = 50>
          <input type="radio" name="shape" value="5"> <img src="assets/icons/flower05.png" width = 50 height = 50>

          <br>
          Name:
          <input type="text" name="uName"><br>
          <h5> Use the Preview Icon to pick a spot for your flower!</h5>
          <button id="pckSpotBtn" type = "submit">Pick a spot!</button>
          <br>
          <button id="cancelButton" type="button">Cancel</button>

        </form>
      </div>
  </body>
</html>

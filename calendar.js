class Calendar {
    constructor() {
        this.currentDate = new Date();
        this.day = this.currentDate.getDate();
        this.month = this.currentDate.getMonth();
        this.year = this.currentDate.getFullYear();

        this.calendarContener = null;
        this.calendarHeader = null;
        this.calendarTable = null;
        this.calendarDateText = null;
        this.selectedDay = null;
        
    }
    

    initCalendar() {
        
        this.calendarContener = document.querySelector(".calendar-contener");

        this.calendarTable = document.createElement("div");
        this.calendarContener.appendChild(this.calendarTable);

        //tworzymy div z nazwą miesiąca
        this.calendarDateText = document.createElement("div");
        this.calendarDateText.className = "date-name";
        this.createDateText();

        this.divButtons = document.createElement("div");
        this.divButtons.className = "calendar-prev-next";
        this.createButtons();
        

        //tworzymy nagłówek kalendarza
        this.calendarHeader = document.createElement("div");
        this.calendarHeader.classList.add("calendar-header");

        this.calendarContener.appendChild(this.calendarHeader);
        this.calendarHeader.appendChild(this.divButtons);
        this.calendarHeader.appendChild(this.calendarDateText);
        

        this.createCalendarTable();

        function addNote() { 
            console.log("dodaje notatke");
            if (Calendar.selectedDay != null)
            {   
                let noteText = document.querySelector(".note").value;
                //let noteToWrite = new Blob([noteText], {type:"text/plain"});
                //let textToFetchURL = window.URL.createObjectURL(noteToWrite);
                let noteNameWithoutSpace = Calendar.selectedDay.split(" ");
                let noteName = noteNameWithoutSpace[0] + "-" + noteNameWithoutSpace[1] + "-" + noteNameWithoutSpace[2] + ".txt";


                var my_url="http://localhost/kalendarz/saveNote.php";
                $.ajax({
                    type: "POST",
                    url: my_url,
                    data: { filecode: noteText , zapis: noteName}
                }).done(function(msg) {
                    alert("zapisano!");
                });
            }
        }

        const btn = document.querySelector(".noteBtn");
        btn.addEventListener("click", addNote);
    }
    
    createButtons() {
        const buttonPrev = document.createElement("button");
        buttonPrev.innerText = "<";
        buttonPrev.type = "button";
        buttonPrev.classList.add("input-prev");
        buttonPrev.addEventListener("click", e => {
            this.month--;
            if (this.month < 0) {
                this.month = 11;
                this.year--;
            }
            this.createCalendarTable();
            this.createDateText();
        });
        this.divButtons.appendChild(buttonPrev);

        const buttonNext = document.createElement("button");
        buttonNext.classList.add("input-next");
        buttonNext.innerText = ">";
        buttonNext.type = "button";
        buttonNext.addEventListener("click", e => {
            this.month++;
            if (this.month > 11) {
                this.month = 0;
                this.year++;
            }
            this.createCalendarTable();
            this.createDateText();
        });
        this.divButtons.appendChild(buttonNext);
    }


    createDateText() {
        const monthNames = ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", 
        "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"];
        this.calendarDateText.innerHTML = monthNames[this.month] + " " + this.year;
    }

    createCalendarTable() {
        this.calendarTable.innerHTML = "";

        const tab = document.createElement("table");
        tab.classList.add("calendar-table");

        let tr = document.createElement("tr");
        tr.classList.add("calendar-table-days-names");
        const days = ["Pon", "Wto", "Śro", "Czw", "Pią", "Sob", "Nie"];
        days.forEach(day => {
            const th = document.createElement("th");
            th.innerHTML = day;
            tr.appendChild(th);
        });
        tab.appendChild(tr);

        const daysInMonth = new Date(this.year, this.month+1, 0).getDate();

        const tempDate = new Date(this.year, this.month, 1);
        let firstMonthDay = tempDate.getDay();
        if (firstMonthDay === 0) {
            firstMonthDay = 7;
        }

        const j = daysInMonth + firstMonthDay - 1;

        if (firstMonthDay - 1 !== 0) {
            tr = document.createElement("tr");
            tab.appendChild(tr);
        }

        for (let i=0; i < firstMonthDay - 1; i++) {
            const td = document.createElement("td");
            td.innerHTML = "";
            tr.appendChild(td);
        }

        //tworzymy komórki dni
        for (let i = firstMonthDay-1; i<j; i++) {
            if(i % 7 === 0){
                tr = document.createElement("tr");
                tab.appendChild(tr);
            }

            const td = document.createElement("td");
            td.innerText = i - firstMonthDay + 2;
            td.dayNr = i - firstMonthDay + 2;
            td.classList.add("day");

            if (this.year === this.currentDate.getFullYear() && this.month === this.currentDate.getMonth() && this.day === i - firstMonthDay + 2) {
                td.classList.add("current-day")
            }

            tr.appendChild(td);
        }

        tab.appendChild(tr);

        this.calendarTable.appendChild(tab);

        this.selectDate = () => {
            Calendar.selectedDay = event.currentTarget.innerText + " " + document.querySelector(".date-name").innerText;
            //////////
            //const apiUrl = "http://localhost/kalendarz";
            //const url = apiUrl + Calendar.selectedDay;
            //fetch(apiUrl).then(response => consile.log("cos"));
            console.log(Calendar.selectedDay);

            let noteNameWithoutSpace = Calendar.selectedDay.split(" ");
            let noteName = noteNameWithoutSpace[0] + "-" + noteNameWithoutSpace[1] + "-" + noteNameWithoutSpace[2] + ".txt";

            

            /////////////////////////////// read note
            let XmlHttp; 
            let noteContent;
            XmlHttp = new XMLHttpRequest();
            XmlHttp.open('GET', 'http://localhost/kalendarz/data/' + noteName, false);
            XmlHttp.send();
            if(XmlHttp.status == 200)
            {
                noteContent = XmlHttp.responseText;
                document.querySelector(".note").innerHTML = noteContent;
            }
            
        }

        this.addEvents = (d) => {
            d.addEventListener("click", this.selectDate);
        }

        const daysList = document.querySelectorAll(".day");
        daysList.forEach(this.addEvents);

        
    }
    
    
}

const cal = new Calendar();
cal.initCalendar();


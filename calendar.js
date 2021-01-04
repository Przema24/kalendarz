class Calendar {
    constructor() {
        this.currentDate = new Date();
        this.day = this.currentDate.getDate();
        this.month = this.currentDate.getMonth();
        this.year = this.currentDate.getFullYear();
    }
}


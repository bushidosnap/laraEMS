export default class Gate {
    constructor(user) {
        this.user = user;
    }

    isAdminManager() {
        return this.user.type === "admin" || this.user.type === "manager";
    }

    isAdmin() {
        return this.user.type === "admin";
    }

    isManager() {
        return this.user.type === "manager";
    }

    isUser() {
        return this.user.type === "user";
    }
}

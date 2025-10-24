# Booking System Flowcharts

## Client Flow

```mermaid
flowchart TD
    Start((Start))
    Success((Booking Success))
    A[/Landing Page/]
    B[/View Services/]
    C[/View About/]
    G[Booking Step 1: Enter Details]
    H[Booking Step 2: Select Service/Therapist]
    I[Booking Step 3: Pick Date/Time]
    J[Booking Step 4: Confirm Details]
    K[Booking Step 5: Verification Code]
    M[/Resend Code/]
    N[/Submit Feedback/]
    O[/View Therapist Availability/]

    Start --> A
    A --> B
    A --> C
    A --> G
    G --> H
    H --> I
    I --> J
    J --> K
    K --> Success
    K --> M
    Success --> N
    G --> O
```

## Admin Flow

```mermaid
flowchart TD
    A[Admin Login] --> B{2FA Enabled?}
    B -- Yes --> C[2FA Verification]
    B -- No --> D[Dashboard]
    C --> D
    D[Dashboard] --> E[Manage Bookings]
    D --> F[Manage Therapists]
    D --> G[Manage Services]
    D --> H[Manage Branches]
    D --> I[Manage Users]
    D --> J[Export Revenue Reports]
    D --> K[Manage Payrolls]
    D --> L[View Feedback]
    E --> M[Create/Cancel Booking]
    F --> N[CRUD Therapists]
    G --> O[CRUD Services]
    H --> P[CRUD Branches]
    I --> Q[CRUD Users]
    J --> R[Export PDF/Excel]
    K --> S[Payroll Actions]
    L --> T[Toggle Feedback Display]
    D --> U[Logout]
```

# Admin Flowcharts (Page by Page)

## 1. Login & 2FA
```mermaid
flowchart TD
    Start((Start))
    Login[Admin Login]
    TwoFA{2FA Enabled?}
    Verify[2FA Verification]
    Dashboard[Dashboard]
    Logout((Logout))

    Start --> Login
    Login --> TwoFA
    TwoFA -- Yes --> Verify
    TwoFA -- No --> Dashboard
    Verify --> Dashboard
    Dashboard --> Logout
```

## 2. Dashboard
```mermaid
flowchart TD
    Dashboard[Dashboard]
    Bookings[Go to Bookings]
    Therapists[Go to Therapists]
    Services[Go to Services]
    Branches[Go to Branches]
    Users[Go to Users]
    Reports[Go to Revenue Reports]
    Payrolls[Go to Payrolls]
    Feedback[Go to Feedback]
    Logout((Logout))

    Dashboard --> Bookings
    Dashboard --> Therapists
    Dashboard --> Services
    Dashboard --> Branches
    Dashboard --> Users
    Dashboard --> Reports
    Dashboard --> Payrolls
    Dashboard --> Feedback
    Dashboard --> Logout
```

## 3. Bookings Management
```mermaid
flowchart TD
    Bookings[Bookings Page]
    Create[Create Booking]
    Cancel[Cancel Booking]
    View[View Booking Details]
    Back[Back to Dashboard]

    Bookings --> Create
    Bookings --> Cancel
    Bookings --> View
    Bookings --> Back
```

## 4. Therapists Management (CRUD)
```mermaid
flowchart TD
    Therapists[Therapists Page]
    Create[Create Therapist]
    Read[View Therapists]
    Update[Update Therapist]
    Delete[Delete Therapist]
    Back[Back to Dashboard]

    Therapists --> Create
    Therapists --> Read
    Therapists --> Update
    Therapists --> Delete
    Therapists --> Back
```

## 5. Services Management (CRUD)
```mermaid
flowchart TD
    Services[Services Page]
    Create[Create Service]
    Read[View Services]
    Update[Update Service]
    Delete[Delete Service]
    Back[Back to Dashboard]

    Services --> Create
    Services --> Read
    Services --> Update
    Services --> Delete
    Services --> Back
```

## 6. Branches Management (CRUD)
```mermaid
flowchart TD
    Branches[Branches Page]
    Create[Create Branch]
    Read[View Branches]
    Update[Update Branch]
    Delete[Delete Branch]
    Back[Back to Dashboard]

    Branches --> Create
    Branches --> Read
    Branches --> Update
    Branches --> Delete
    Branches --> Back
```

## 7. Users Management (CRUD)
```mermaid
flowchart TD
    Users[Users Page]
    Create[Create User]
    Read[View Users]
    Update[Update User]
    Delete[Delete User]
    Back[Back to Dashboard]

    Users --> Create
    Users --> Read
    Users --> Update
    Users --> Delete
    Users --> Back
```

## 8. Revenue Reports
```mermaid
flowchart TD
    Reports[Revenue Reports Page]
    ExportPDF[/Export PDF/]
    ExportExcel[/Export Excel/]
    Back[Back to Dashboard]

    Reports --> ExportPDF
    Reports --> ExportExcel
    Reports --> Back
```

## 9. Payrolls
```mermaid
flowchart TD
    Payrolls[Payrolls Page]
    Create[Create Payroll]
    AddItem[Add Payroll Item]
    RemoveItem[Remove Payroll Item]
    AddPayment[Add Payment]
    ExportCSV[/Export CSV/]
    ExportPDF[/Export PDF/]
    Back[Back to Dashboard]

    Payrolls --> Create
    Payrolls --> AddItem
    Payrolls --> RemoveItem
    Payrolls --> AddPayment
    Payrolls --> ExportCSV
    Payrolls --> ExportPDF
    Payrolls --> Back
```

## 10. Feedback
```mermaid
flowchart TD
    Feedback[Feedback Page]
    Toggle[Toggle Feedback Display]
    Back[Back to Dashboard]

    Feedback --> Toggle
    Feedback --> Back
```

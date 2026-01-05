Sub FN_01()

    On Error Resume Next  ' Enable error handling

    Dim train_no, date_of_testing, load, staff_no, road_no, wagon_type, pipe_type
    Dim objconn, commandtext
    Dim strError, dbPath, logFile, fso, file
    Dim timeStamp

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Create connection object
    Set objconn = CreateObject("ADODB.Connection")

    ' DSN-less SQLite ODBC connection string
    objconn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Read values from HMI SmartTags
    train_no = HmiRuntime.SmartTags("NEW_RTR_TRAIN_NO")
    date_of_testing = HmiRuntime.SmartTags("NEW_RTR_DATE_OF_TESTING")
    load = HmiRuntime.SmartTags("NEW_RTR_LOAD")
    staff_no = HmiRuntime.SmartTags("NEW_RTR_STAFF_NO")
    road_no = HmiRuntime.SmartTags("NEW_RTR_ROAD_NO")

    ' Pipe Type Logic
    Select Case HmiRuntime.SmartTags("NEW_RTR_PIPE_TYPE")
    Case 0
        pipe_type = "Nothing Selected"
    Case 1
        pipe_type = "Single Pipe"
    Case Else
        pipe_type = "Twin Pipe"
    End Select

    ' Wagon Type Logic
    If HmiRuntime.SmartTags("NEW_RTR_WAGON_TYPE") = 1 Then
        wagon_type = "LHB"
    Else
        wagon_type = "ICF"
    End If

    ' Build SQL INSERT query
    commandtext = "INSERT INTO train_maintenance_report " & _
                  "(train_no, date_of_testing, load, staff_no, road_no, wagon_type, pipe_type) " & _
                  "VALUES ('" & train_no & "','" & date_of_testing & "','" & load & "','" & staff_no & "','" & road_no & "','" & wagon_type & "','" & pipe_type & "')"

    ' Execute SQL
    objconn.Execute commandtext

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_01 Error: " & Err.Description
        timeStamp = Now

        ' Log error to text file
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True) ' 8 = Append mode
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close and clean up
    objconn.Close
    Set objconn = Nothing

End Sub
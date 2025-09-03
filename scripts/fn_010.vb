Sub FN_010()

    On Error Resume Next

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id, front_car_time1, rear_car_time1, front_car_time2, rear_car_time2

    ' Get DB and log paths from SmartTags
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get test ID
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Get values from tags
    front_car_time1 = HmiRuntime.SmartTags("FRONT_CAR_TIME1")
    rear_car_time1  = HmiRuntime.SmartTags("REAR_CAR_TIME1")
    front_car_time2 = HmiRuntime.SmartTags("FRONT_CAR_TIME2")
    rear_car_time2  = HmiRuntime.SmartTags("REAR_CAR_TIME2")

    ' Open DB Connection
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if record exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_08 WHERE id=" & test_id
    Set objRS = objConn.Execute(checkQuery)

    ' Insert or Update based on record availability
    If objRS("cnt") > 0 Then
        sqlQuery = "UPDATE tbl_lhb_08 SET " & _
                   "front_car_time1='" & front_car_time1 & "', " & _
                   "rear_car_time1='" & rear_car_time1 & "', " & _
                   "front_car_time2='" & front_car_time2 & "', " & _
                   "rear_car_time2='" & rear_car_time2 & "' " & _
                   "WHERE id=" & test_id
    Else
        sqlQuery = "INSERT INTO tbl_lhb_08 (id, front_car_time1, rear_car_time1, front_car_time2, rear_car_time2) VALUES (" & _
                   test_id & ",'" & front_car_time1 & "','" & rear_car_time1 & "','" & front_car_time2 & "','" & rear_car_time2 & "')"
    End If

    ' Execute query
    objConn.Execute sqlQuery

    ' Error handling and log writing
    If Err.Number <> 0 Then
        strError = "Error in FN_010: " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close objects
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub

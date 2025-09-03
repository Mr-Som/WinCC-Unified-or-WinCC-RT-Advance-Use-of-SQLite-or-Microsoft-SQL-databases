Sub FN_009()

    On Error Resume Next

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id, coach_nos

    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")
    coach_nos = HmiRuntime.SmartTags("PEASD_COACH")

    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_07 WHERE id=" & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        sqlQuery = "UPDATE tbl_lhb_07 SET coach_nos='" & coach_nos & "' WHERE id=" & test_id
    Else
        sqlQuery = "INSERT INTO tbl_lhb_07 (id, coach_nos) VALUES (" & test_id & ",'" & coach_nos & "')"
    End If

    objConn.Execute sqlQuery

    If Err.Number <> 0 Then
        strError = "Error in FN_009: " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub

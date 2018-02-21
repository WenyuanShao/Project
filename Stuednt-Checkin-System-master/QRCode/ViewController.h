//
//  ViewController.h
//  Sample login
//
//  Created by 邵闻远 on 20/04/2017.
//  Copyright © 2017 shaowy. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface ViewController : UIViewController

@property (strong, nonatomic) IBOutlet UITextField *Gid;
@property (strong, nonatomic) IBOutlet UITextField *password;

@property (nonatomic, retain) NSString *str;

- (IBAction)loginbutton:(id)sender;
@end

